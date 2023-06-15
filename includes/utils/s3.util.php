<?php
// S3 functions
require_once YIPNYAP_PATH . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Supabase\Storage\StorageFile;

/**
 * @throws Exception
 */
function SupabaseUserContentUpload(string $userID, string $file, string|null $E2Parent = null): array {
    $api_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE4NDA2NDQwNzMsImlhdCI6MTY4Mjg1OTY3MywiaXNzIjoic3VwYWJhc2UiLCJyb2xlIjoic2VydmljZV9yb2xlIn0.gkE8UszdjI3z2Nz9j5qXczGM7HV5xl6SfbEOVuphQU0';
    $StorageFile = new StorageFile($api_key, 'supabase', YIPNYAP_IS_LOCAL_DEV ? 'dev-users' : 'users', 'yipnyap.me');

    // Key should be something like: <user_id>/<E2Object>/<E2ID>/<E2IDOfContent>.<extension>
    $E2ID = $E2Parent ?? E2IDCreate('Post', 'PARENT');
    $E2IDOfContent = E2IDCreate('Post', 'CONTENT_IMAGE', $E2ID . ':');
    $key = $userID . '/posts/' . $E2ID . '/' . $E2IDOfContent . '.' . pathinfo($file, PATHINFO_EXTENSION);

    $response = $StorageFile->upload($key, $file, ['public' => true]);
    if ($response->getStatusCode() == 200) {
        return [
            'success' => true,
            'response' => [
                'id' => $E2IDOfContent,
                'key' => $key,
            ]
        ];
    } else {
        return [
            'success' => false,
            'response' => 'Error uploading file to Storage'
        ];
    }
}

class SupabaseControl
{
    public string $api_key;

    public function __construct()
    {
        $this->api_key = $_ENV['SUPABASE_API_KEY'];
    }

    /**
     * @throws GuzzleException
     */
    public static function __HttpGETRequest(string $queryRaw, bool $isView = false): ResponseInterface
    {
        $Control = new SupabaseControl();
        $client = new Client([
            'headers' => [
                'apikey' => $Control->api_key,
                'Authorization' => "Bearer $Control->api_key",
                'User-Agent' => 'Yipnyap/1.0.0',
            ]
        ]);
        if ($isView) {
            $query = $queryRaw;
        } else {
            $query = "likes/$queryRaw";
        }
        return $client->request('GET', "https://supabase.yipnyap.me/rest/v1/$query");
    }

    /**
     * @throws GuzzleException
     */
    public static function __HttpPOSTRequest(array $body): ResponseInterface {
        $Control = new SupabaseControl();
        $client = new Client([
            'headers' => [
                'apikey' => $Control->api_key,
                'Authorization' => "Bearer $Control->api_key",
                'Content-Type' => 'application/json',
                'Prefer' => 'return=minimal',
            ]
        ]);
        return $client->request('POST', 'https://supabase.yipnyap.me/rest/v1/likes', [
            'json' => $body
        ]);
    }

    /**
     * Get most recurring posts
     *
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public static function GetMostPopularPosts(): array
    {
        $analyticalTimeStart = microtime(true);
        $query = '/popular_posts';
        try {
            $response = self::__HttpGETRequest($query, true);
            $response = json_decode($response->getBody()->getContents(), true);
            $analyticalTimeEnd = microtime(true);
            $analyticalTime = $analyticalTimeEnd - $analyticalTimeStart;
            return [
                'success' => true,
                'posts' => array_map(function ($item) {
                    return $item['parent_e2id'];
                }, $response),
                'time' => $analyticalTime,
            ];
        } catch (RequestException $ex) {
            throw new Exception($ex->getResponse()->getBody()->getContents());
            // you can even json_decode the response like json_decode($ex->getResponse()->getBody()->getContents(), true)
        }
    }


    /**
     * @throws GuzzleException
     */
    public static function CheckLike(string $E2Post, string $E2User) {
        $query = "?select=e2id&parent_e2id=eq.$E2Post&user_e2id=eq.$E2User";
        $response = self::__HttpGETRequest($query);
        $response = json_decode($response->getBody()->getContents(), true);
        if (count($response) > 0) {
            return $response[0]['e2id'];
        } else {
            return false;
        }
    }

    /**
     * Insert a like
     *
     * @param string $E2Post
     * @param string $E2User
     * @return bool
     * @throws Exception|GuzzleException
     */
    public static function InsertLike(string $E2Post, string $E2User): bool {
        // Check for existing like
        $existingLike = self::CheckLike($E2Post, $E2User);
        if ($existingLike) {
            return true;
        }

        $response = @self::__HttpPOSTRequest([
            'e2id' => E2IDCreate('Post', 'INTERACTION_LIKE'),
            'parent_e2id' => $E2Post,
            'user_e2id' => $E2User,
        ]);
        $success = !empty($response) && $response->getStatusCode() == 201;
        if (!$success) {
            throw new Exception('Error inserting like');
        }

        return true;
    }
}