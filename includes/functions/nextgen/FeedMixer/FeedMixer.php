<?php
namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/utils/e2.util.php';
require_once YIPNYAP_PATH . '/includes/utils/s3.util.php';

use Exception;

/**
 * Feed Mixer. Creates a feed from multiple sources, including groups, users, and
 * some other stuff. Also manages importing feeds from other sources, such as
 * FurAffinity.
 *
 * @package    Yipnyap
 * @subpackage FeedMixer
 * @since      ui3
 * @version    ui3
 * @access     public
 */
class FeedMixer
{
    public string $FeedE2ID; // Yeah, bringing this mess back.
    public string $FeedType; // Type taken from E2.
    public int $FeedID; // The ID of the feed, i.e. `hhhhhhhhhhhh` for `01A1hhhhhhhhhhhh`

    public function __construct(string $feed_e2_id = '01A10')
    {
        if ($feed_e2_id) {
            // Check if the ID is just a number. If it is, it's legacy and needs to be converted.
            if (is_numeric($feed_e2_id)) {
                // Just assume by default it's a user
                $feed_e2_id = '01A9' . $feed_e2_id;
            }

            $this->FeedE2ID = $feed_e2_id;
            $this->FeedType = E2IDTypeIDToName(substr($feed_e2_id, 0, 2));
            // Variant is always A1
            $this->FeedID = substr($feed_e2_id, 4);
        }
    }

    /**
     * Build the global guest feed.
     * It sorts by date and reaction count.
     */
    public function MixGuestFeed(int $page = 1): array {
        global $wpdb;

        $feed = [];
        $tableName = $wpdb->prefix . 'vkreact_activity_user_reaction';
        $reactionTableName = $wpdb->prefix . 'vkreact_reaction';
        $reactionSQL = "SELECT id, activity_id, COUNT(id) AS reaction_count FROM $tableName
              AS reactions
              INNER JOIN $reactionTableName AS reactionTable ON reactions.reaction_id=reactionTable.id
              GROUP BY activity_id
              ORDER BY reaction_count DESC
              LIMIT 100";

        // Make sure activity_id is unique
        $reactions = $wpdb->get_results($reactionSQL);

        // Randomize entries
        shuffle($reactions);

        // Get the activity IDs
        $activityIDs = array_map(function($reaction) {
            return $reaction->activity_id;
        }, $reactions);

        $bp_posts = bp_activity_get([
            'in' => $activityIDs,
            'per_page' => 10,
            'page' => $page,
            'display_comments' => 'threaded',
        ]);

        foreach ($bp_posts['activities'] as $post) {
            $feed[] = yipnyap_activity_data_get($post, [], true);
        }

        return $feed;
    }

    /**
     * Do faxp importing (for FurAffinity -> Yipnyap)
     *
     * @throws Exception
     * @todo   Move to some sort of Post class.
     */
    public function ImportFAXP(string $faxp = ''): void
    {
        // check if $faxp is valid JSON
        $faxp = json_decode($faxp);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON.');
        }

        /**
         * FAXP is the following format:
         * [
         *    {
         *      "id": "1234567890",
         *      "title": "Title",
         *      "description": "Description",
         *      "tags": ["tag1, tag2, tag3"],
         *      "rating": "General",
         *      "image": "https://d.furaffinity.net/art/<etc>"
         *      "date": 1666442820000,
         *      "scrap": false,
         *   },
         *  { ... }
         * ]
         */
        if (!is_array($faxp)) {
            throw new Exception('Invalid FAXP format.');
        }

        // Check each entry. If any are invalid, remove them.
        foreach ($faxp as $key => $entry) {
            // Check if it's an object
            if (!is_object($entry)) {
                unset($faxp[$key]);
                continue;
            }

            // Check if it has all the required properties
            if (!isset($entry->id)
                || !isset($entry->title)
                || !isset($entry->description)
                || !isset($entry->tags)
                || !isset($entry->rating)
                || !isset($entry->image)
                || !isset($entry->date)
                || !isset($entry->scrap)) {
                unset($faxp[$key]);
                continue;
            }

            // Check if it's a valid rating
            if (!in_array($entry->rating, ['General', 'Mature', 'Adult'])) {
                unset($faxp[$key]);
                continue;
            }

            // Check if it's a valid date
            if (!is_numeric($entry->date)) {
                unset($faxp[$key]);
                continue;
            }

            // Check if it's a valid scrap
            if (!is_bool($entry->scrap)) {
                unset($faxp[$key]);
                continue;
            }

            // Check if it's a valid image
            if (!filter_var($entry->image, FILTER_VALIDATE_URL)) {
                unset($faxp[$key]);
                continue;
            }

            // Check if the image is a valid FA image (starts with https://d.furaffinity.net/art/, ends with a valid extension)
            if (!preg_match('/^https:\/\/d\.furaffinity\.net\/art\/.*\.(jpg|jpeg|png|gif|mp4)$/', $entry->image)) {
                unset($faxp[$key]);
            }
        }

        // Check if there are any entries left
        if (empty($faxp)) {
            throw new Exception('No valid entries.');
        }

        // Build an object of posts to parse to bp_activity_add.
        // We also need to download the images and associate them with the post via bp_activity_update_meta.
        $posts = [];
        foreach ($faxp as $entry) {
            // Add the post to the list of posts to parse
            $posts[] = [
                'id' => $entry->id,
                'title' => $entry->title,
                'description' => $entry->description,
                'tags' => $entry->tags,
                'rating' => $entry->rating,
                'image' => $entry->image,
                'date' => $entry->date,
                'scrap' => $entry->scrap,
            ];

            // Download the image to Digitalocean and get the file path
            $request = wp_remote_get($entry->image);
            if (is_wp_error($request)) {
                throw new Exception('Error downloading image.');
            }

            S3UserContentUpload(get_current_user_id(), $request['body'], '');

            // Add the image to the list of images to parse
            $images[] = [
                'id' => $entry->id,
            ];
        }
    }

    /**
     * Create a post via bp_activity_add
     *
     * @param array $post
     * @return bool
     * @throws Exception
     */
    public function CreatePost(array $post): bool
    {
        $postSchema = [
            // 'parent' => 'E2ID:User',
            'title' => 'string',
            'body' => 'string',
            'tags' => ['string'],
            'rating' => ['general', 'mature', 'explicit', 'unknown'],
            'image' => 'string',
        ];

        // Check if the post is valid
        foreach ($postSchema as $key => $type) {
            // Check if the key exists
            if (!isset($post[$key])) {
                throw new Exception('Missing key.');
            }

            // Check if the type is correct
            if (gettype($post[$key]) !== $type) {
                throw new Exception('Invalid type.');
            } elseif (gettype($post[$key]) === 'array') {
                foreach ($post[$key] as $item) {
                    if (gettype($item) !== $type) {
                        throw new Exception('Invalid type.');
                    }
                }
            } elseif (gettype($post[$key]) === 'string') {
                if (!in_array($post[$key], $type)) {
                    throw new Exception('Invalid type.');
                }
            }

            // Check if the post tags don't exceed the limit
            if (count($post['tags']) > 10) {
                throw new Exception('Too many tags.');
            }
        }

        // Create the post
        $post_id = bp_activity_add([
            'content' => $post['body'],
            'user_id' => get_current_user_id(),
        ]);

        // Check for content to upload with the post ($post['content'] is array or undefined)
        if (isset($post['content'])) {
            // Check if the content is an array of strings
            if (gettype($post['content']) !== 'array') {
                throw new Exception('Invalid content.');
            }

            foreach ($post['content'] as $content) {
                if (gettype($content) !== 'string') {
                    throw new Exception('Invalid content.');
                }
            }
        }

        return true;
    }
}