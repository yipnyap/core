<?php
namespace Yipnyap;

require_once YIPNYAP_PATH . '/includes/utils/e2.util.php';
require_once YIPNYAP_PATH . '/includes/utils/s3.util.php';

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use SupabaseControl;

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
    public string $FeedID; // The ID of the feed

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
            $this->FeedID = $feed_e2_id;
        }
    }

    /**
     * Build the global guest feed.
     * It sorts by date and reaction count.
     */
    public static function MixGuestFeed(int $page = 1): array {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bp_activity_meta';
        $reactionSQL = "SELECT activity_id, COUNT(meta_value) AS like_count FROM $tableName
              AS likes
              GROUP BY activity_id
              ORDER BY like_count DESC
              LIMIT 10";

        $reactions = $wpdb->get_results($reactionSQL);
        $activityIDs = array_map(function($reaction) {
            return $reaction->activity_id;
        }, $reactions);

        $bp_posts = bp_activity_get([
            'fields' => 'ids',
            'in' => $activityIDs,
            'per_page' => 10,
            'page' => $page,
            'count_total' => true,
        ]);

        $posts = self::GetPosts($bp_posts['activities']);
        shuffle($posts);
        return [
//            'time' => $supabaseRequest['time'],
            'posts' => $posts,
            'total' => $bp_posts['total'],
        ];
    }

    /**
     * Get a user's feed. Based on the groups they're in, who they follow, etc.
     *
     * (UserID is already set in the constructor)
     * @param int $page
     * @return array
     * @throws Exception
     */
    public function MixFeed(int $page = 1): array {
        global $wpdb;

        // Convert the E2ID to a Legacy ID
        $legacyID = $wpdb->get_var("SELECT user_id FROM wp_usermeta WHERE meta_key='E2ID' AND meta_value='$this->FeedID'");

        // Get the user's following as it works differently to others
        $following = bp_follow_get_following([
            'user_id' => $legacyID,
        ]);

        // Append the user's ID to the following array
        $following[] = $legacyID;

        // Get all posts from the IDs
        $userPosts = bp_activity_get([
            'filter' => [
                'user_id' => $following,
                'action' => ['activity_update', 'activity_share', 'activity_media_update', 'activity_video_update'],
            ],
            'per_page' => 10,
            'page' => $page,
            'fields' => 'ids',
            'count_total' => true,
        ]);

        // Get all posts from groups & friends
        $groupPosts = bp_activity_get([
            'scope' => ['groups', 'friends'],
            'per_page' => 10,
            'page' => $page,
            'fields' => 'ids',
            'count_total' => true,
        ]);

        // Merge the two arrays
        $allPosts = array_merge($userPosts['activities'], $groupPosts['activities']);
        $allPosts = self::GetPosts($allPosts);

        return [
            'posts' => $allPosts,
            'page' => $page,
            'total' => $userPosts['total'] + $groupPosts['total'],
        ];
    }

    /**
     * Get a (single or list) of activities, formatted for Nextgen
     *
     * @param array $ids
     * @return array
     * @throws Exception
     * @todo: STRIP BUDDYPRESS' STUPID FUCKERY, MOTHERFLUFFER! (oh and also move this to a class uwu~)
     */
    public static function GetPosts(array $ids = []): array {
        $bp_posts = bp_activity_get([
            'in' => $ids,
            'display_comments' => 'threaded'
        ]);

        $activities = [];
        foreach ($bp_posts['activities'] as $post) {
            // Check if $post->type is in array
            $forbiddenTypes = ['activity_video', 'activity_media'];
            if (in_array($post->type, $forbiddenTypes)) continue;

            $post->content = html_entity_decode(stripcslashes($post->content));

            $E2PostID = bp_activity_get_meta($post->id, 'E2ID');
            if (empty($E2PostID)) {
                $E2PostID = E2IDCreate('Post');
                bp_activity_update_meta($post->id, 'E2ID', $E2PostID);
            }

            $build = [
                'id' => $E2PostID,
                // date to unix milliseconds
                'timestamp' => strtotime($post->date_recorded),
                'user' => YipnyapGetMember($post->user_id, null, false, true),
                'replies' => [],
                'likes' => count(bp_activity_get_meta($post->id, 'liked_by', false)),
            ];

            $EditorBlocksLocation = bp_activity_get_meta($post->id, 'blocks_url');
            if (!empty($EditorBlocksLocation)) {
                $BlocksURL = 'https://supabase.yipnyap.me/storage/v1/object/public/users/' . $EditorBlocksLocation;
                $JSONDecoded = @json_decode(file_get_contents($BlocksURL));
                // Check for HTTP 200
                if (!empty($JSONDecoded)) {
                    $build['content'] = $JSONDecoded;
                } else {
                    $build['content'] = [
                        'time' => $build['timestamp'],
                        'version' => '2.22.2',
                        'blocks' => [
                            [
                                'type' => 'paragraph',
                                'data' => [
                                    'text' => $post->content,
                                ],
                            ],
                        ],
                    ];
                }
            } else {
                $build['content'] = [
                    'time' => $build['timestamp'],
                    'version' => '2.22.2',
                    'blocks' => [
                        [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => $post->content,
                            ],
                        ],
                    ],
                ];
            }

            // Sift through replies if any
            if (!empty($post->children)) {
                $build['replies'] = self::GetCommentThread($post->children, $post->id);
            }

            // Get media - Legacy
            if (($post->type === 'activity_media_update') || ($post->type === 'activity_video_update')) {
                $uploadedIDs = bp_activity_get_meta($post->id, 'uploaded_media_id', false);
                $type = ($post->type === 'activity_media_update') ? 'CONTENT_IMAGE' : 'CONTENT_VIDEO';

                foreach ($uploadedIDs as $uploadedID) {
                    $mediaObject = vkmedia_get_media($uploadedID);
                    $build['objects'][] = [
                        'id' => $E2PostID . ':' . LegacyIDToE2ID($mediaObject->id, 'Post', $type),
                        'url' => $mediaObject->link,
                    ];
                }
            }

            // Get legacy reactions & add them to the likes integer
            $legacyReactions = vkreact_bp_get_activity_reactions($post->id);
            foreach ($legacyReactions as $legacyReaction) {
                $build['likes'] = $build['likes'] + $legacyReaction->reaction_count;

                // Filter through & migrate reactions
                foreach ($legacyReaction->users as $reactingUser) {
                    $reactingUser = YipnyapGetMember($reactingUser, null, false, true);
                    //$migrateSuccess = SupabaseControl::InsertLike($build['id'], YipnyapGetMemberE2ID($reactingUser['id']));

                    // Check if alrady liked
                    $alreadyLiked = bp_activity_get_meta($post->id, 'liked_by', false);
                    if (!empty($alreadyLiked)) {
                        if (in_array(YipnyapGetMemberE2ID($reactingUser['id']), $alreadyLiked)) {
                            vkreact_bp_delete_activity_user_reaction([
                                'user_id' => $reactingUser['id'],
                                'activity_id' => $post->id,
                            ]);
                            continue;
                        }
                    }

                    // Add the like into meta
                    $migrateSuccess = bp_activity_add_meta($post->id, 'liked_by', YipnyapGetMemberE2ID($reactingUser['id']));
                    if ($migrateSuccess) {
                        vkreact_bp_delete_activity_user_reaction([
                            'user_id' => $reactingUser['id'],
                            'activity_id' => $post->id,
                        ]);
                    }
                }
            }

            // If the user is signed out, remove the timestamp
            if (!is_user_logged_in()) {
                unset($build['timestamp']);
            }

            $activities[] = $build;
        }

        return $activities;
    }

    /**
     * Get comment data recursively
     *
     * @param array $comments
     * @param int|null $parentID - NOT E2ID.
     * @param bool $digDeeper
     * @return array
     * @throws Exception
     */
    public static function GetCommentThread(array $comments, int $parentID = null, bool $digDeeper = true): array
    {
        $build = [];

        foreach ($comments as $comment) {
            $comment->content = stripcslashes($comment->content);
            $E2CommentID = bp_activity_get_meta($comment->id, 'E2ID');

            if (empty($E2CommentID)) {
                $E2CommentID = LegacyIDToE2ID($comment->id, 'Post', 'INTERACTION_HOWLING_ALONGSIDE');
            }

            $buildReply = [
                'id' => $E2CommentID,
                'user' => YipnyapGetMember($comment->user_id, null, false, true),
                'content' => html_entity_decode(stripcslashes($comment->content)),
            ];

            // Check if they liked the parent
            $liked = in_array(YipnyapGetMemberE2ID($comment->user_id), bp_activity_get_meta($parentID, 'liked_by', false));
            if ($liked) {
                $buildReply['likedParent'] = true;
            }

            // If logged in, add timestamp
            if (is_user_logged_in()) {
                $buildReply['timestamp'] = strtotime($comment->date_recorded);
            }

            // Now do it ~recursively~ (ﾉ◕ヮ◕)ﾉ*:･ﾟ✧
            if (!empty($comment->children) && $digDeeper) {
                $buildReply['replies'] = self::GetCommentThread($comment->children, $comment->id);
            }

            // Testing
//            if ($comment->user_id === 1 && $digDeeper) {
//                $buildReply['replies'] = self::GetCommentThread([$comment], $comment->id, false);
//            }

            $build[] = $buildReply;
        }

        return $build;
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
            // Download the image to Supabase and get the file path
            $image = SupabaseUserContentUpload(get_current_user_id(), $entry->image, '');

            // Add 'nsfw' to the tags if the post is mature or adult
            if ($entry->rating !== 'General') {
                $entry->tags[] = 'nsfw';
            }

            // Add the post to the list of posts to parse
            $posts[] = [
                'content' => [
                    'time' => time(),
                    'version' => '2.22.2',
                    'blocks' => [
                        [
                            'type' => 'header',
                            'data' => [
                                'text' => $entry->title,
                                'level' => 1,
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'data' => [
                                'text' => $entry->description,
                            ],
                        ],
                    ],
                ],
                'tags' => $entry->tags,
                'objects' => [
                    [
                        'id' => $image['id'],
                        'url' => $image['key'],
                    ],
                ],
            ];
        }
    }

    /**
     * Create a post via bp_activity_add
     *
     * @param array $post
     * @return array
     * @throws Exception
     */
    public function CreatePost(array $post): array
    {
        // Check if the post is valid
        if (!empty($post['tags']) && count($post['tags']) > 10) {
            throw new Exception('Too many tags.');
        }

        $UserE2ID = get_user_meta(get_current_user_id(), 'E2ID', true);
        if (empty($UserE2ID)) {
            $NewID = LegacyIDToE2ID(get_current_user_id(), 'User');
            update_user_meta(get_current_user_id(), 'E2ID', $NewID);
            $UserE2ID = $NewID;
        }

        // Create the post
        $E2ID = E2IDCreate('Post', 'PARENT', $UserE2ID . ':');
        $post_id = bp_activity_add([
            'content' => ' ',
            'component' => 'activity',
            'type' => 'activity_update',
        ]);

        if (empty($post_id)) {
            throw new Exception('Failed to create post.');
        }

        // Set the E2ID
        bp_activity_update_meta($post_id, 'E2ID', $E2ID);

        // Set the tags
        if (!empty($post['tags'])) {
            bp_activity_update_meta($post_id, 'tags', implode(',', $post['tags']));
        }

        // Upload the 'content' as a JSON file to Supabase
        $content = $post['content'];

        // - check all the blocks are valid EditorJS blocks
        $contentAsJSON = json_encode($content);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON.');
        }
        if (!isset($content['time'])
            || !isset($content['version'])
            || !isset($content['blocks'])) {
            throw new Exception('Invalid JSON.');
        }
        if (!is_numeric($content['time'])) {
            throw new Exception('Invalid JSON.');
        }
        if (!is_string($content['version'])) {
            throw new Exception('Invalid JSON.');
        }
        if (!is_array($content['blocks'])) {
            throw new Exception('Invalid JSON.');
        }
        foreach ($content['blocks'] as $block) {
            if (!isset($block['type'])
                || !isset($block['data'])) {
                throw new Exception('Invalid JSON.');
            }
            if (!is_string($block['type'])) {
                throw new Exception('Invalid JSON.');
            }
            if (!is_array($block['data'])) {
                throw new Exception('Invalid JSON.');
            }

            // - check the block type is valid
            if (!in_array($block['type'], ['header', 'paragraph', 'list', 'quote', 'code', 'table', 'link'])) {
                throw new Exception('Invalid JSON.');
            }
        }

        // - save to a file locally
        $filename = 'post-' . explode(':', $E2ID)[1] . '-' . time() . '.json';
        $filepath = wp_upload_dir()['basedir'] . '/vault_cache/' . $filename;
        file_put_contents($filepath, $contentAsJSON);

        // - upload to Supabase
        $supabaseObject = SupabaseUserContentUpload($UserE2ID, $filepath);

        // - delete the local file
        if ($supabaseObject['success']) {
            unlink($filepath);

            // - set the post blocks to the Supabase object key
            bp_activity_update_meta($post_id, 'blocks_url', $supabaseObject['response']['key']);
        } else {
            // Undo everything
            bp_activity_delete([
                'id' => $post_id,
            ]);

            throw new Exception('Failed to upload content.');
        }

        return $this->GetPosts([$post_id]);
    }
}