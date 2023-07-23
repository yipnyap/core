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
    $api_key = getenv('YIPNYAP_SUPABASE_SERVICE_KEY');
    $raw_domain = getenv('YIPNYAP_SUPABASE_URL');
    $scheme = explode('://', $raw_domain)[0];
    $reference_id = preg_replace('/https?:\/\//', '', explode('.', $raw_domain)[0]);
    $domain = explode('.', $raw_domain)[1] . '.' . explode('.', $raw_domain)[2];
    $StorageFile = new StorageFile($api_key, $reference_id, 'users', $domain, $scheme);

    // Key should be something like: <user_id>/<E2Object>/<E2ID>/<E2IDOfContent>.<extension>
    $E2ID = $E2Parent ?? E2IDCreate('Post');
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
    public string $domain;
    public string $api_key;

    public function __construct($api_key = null, $domain = null)
    {
        $this->domain = $domain ?? $_ENV['YIPNYAP_SUPABASE_URL'];
        $this->api_key = $api_key ?? $_ENV['YIPNYAP_SUPABASE_SERVICE_KEY'];
    }

    // get()

    /**
     * @throws GuzzleException
     */
    public function get(string $query = ''): ResponseInterface
    {
        return $this->__HttpGETRequest($query);
    }

    /**
     * @throws GuzzleException
     */
    public function __HttpGETRequest(string $query = ''): ResponseInterface
    {
        $client = new Client([
            'headers' => [
                'Authorization' => "Bearer $this->api_key",
                'User-Agent' => 'Yipnyap/1.0.0',
            ]
        ]);

        $domain = $this->domain;
        return $client->request('GET', "$domain/rest/v1/$query");
    }

    /**
     * @throws GuzzleException
     */
    public static function __HttpPOSTRequest(array $body): ResponseInterface
    {
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
}