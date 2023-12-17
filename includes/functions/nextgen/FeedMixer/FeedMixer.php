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
    public string $FeedID; // The ID of the feed
    public bool $OnlyParent = false; // Only get content from the parent

    public function __construct(string $feed_e2_id = '01A10', bool $onlyParent = false, string|bool $TargetOverride = false)
    {
        if ($feed_e2_id) {
            // Check if the ID is just a number. If it is, it's legacy and needs to be converted.
            if (is_numeric($feed_e2_id)) {
                // Just assume by default it's a user
                $feed_e2_id = '01A9' . $feed_e2_id;
            }

            $this->FeedE2ID = $feed_e2_id;
            $this->FeedType = empty($TargetOverride) ? E2IDTypeIDToName(substr($feed_e2_id, 0, 2)) : $TargetOverride;
            // Variant is always A1
            $this->FeedID = $feed_e2_id;
            $this->OnlyParent = $onlyParent;
        }
    }

    /**
     * Build the global guest feed.
     * It sorts by date and reaction count.
     * @throws Exception
     */
    public static function MixGuestFeed(int $page = 1): array
    {
        global $wpdb;

        $offset = ($page - 1) * 10;

        $tableName = $wpdb->prefix . 'bp_activity_meta';
        $reactionSQL = "SELECT activity_id, COUNT(meta_value)
                            AS like_count
                        FROM $tableName
                            AS likes
                        WHERE meta_key = 'liked_by'
                        GROUP BY activity_id
                        ORDER BY like_count DESC
                        LIMIT 100";

        $reactions = $wpdb->get_results($reactionSQL);

        $activityIDs = array_map(function ($reaction) {
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
            'hasMore' => $bp_posts['total'] > ($page * 10),
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
    public function MixFeed(int $page = 1): array
    {
        global $wpdb;

        $legacyUserID = $wpdb->get_var("SELECT user_id FROM wp_usermeta WHERE meta_key='E2ID' AND meta_value='$this->FeedID'");
        if ($this->FeedType === 'Feed') {
            // Feed of the user's home.

            // - get the user's friends and append them to the following array
            $friends = friends_get_friend_user_ids($legacyUserID);
            $following = bp_follow_get_following([
                'user_id' => $legacyUserID,
            ]);

            // Get all posts from the IDs
            $userPostFilter = [
                'filter' => [
//                'action' => ['activity_update'],
                    'action' => ['activity_update', 'activity_share', 'activity_media_update', 'activity_video_update'],
                ],
                'per_page' => 10,
                'page' => $page,
                'fields' => 'ids',
                'count_total' => true,
            ];

            if ($this->FeedID !== 'universe') {
                $userPostFilter['filter']['user_id'] = array_unique([$legacyUserID, ...$friends, ...$following]);
            }

            $userPosts = bp_activity_get($userPostFilter);

            if ($this->FeedID !== 'universe') {
                $groupIDs = groups_get_user_groups($legacyUserID)['groups'];
                /*
                 * So, this causes a bit of a weird thing: groups aren't utilised all the time, so it gets old posts and mixes
                 * them in with the new ones. This is a bit of a problem, but it's not a huge one. It's just a bit weird.
                 *
                 * FUCK IT. its now a feature. pls use groups :(
                 * ^ rek
                 */
                $groupPosts = bp_activity_get([
                    'scope' => ['groups'],
                    'filter' => [
                        'item_id' => $groupIDs,
                        'action' => ['activity_update', 'activity_share', 'activity_media_update', 'activity_video_update'],
                    ],
                    'per_page' => 10,
                    'page' => $page,
                    'fields' => 'ids',
                    'count_total' => true,
                ]);
            } else {
                $groupPosts = [
                    'activities' => [],
                    'total' => 0,
                ];
            }
        } elseif ($this->FeedType === 'User') {
            // Feed of a user's profile.
            $userPosts = bp_activity_get([
                'filter' => [
                    'user_id' => $legacyUserID,
//                'action' => ['activity_update'],
                    'action' => ['activity_update', 'activity_share', 'activity_media_update', 'activity_video_update'],
                ],
                'per_page' => 10,
                'page' => $page,
                'fields' => 'ids',
                'count_total' => true,
            ]);

            $groupPosts = [
                'activities' => [],
                'total' => 0,
            ];
        } elseif ($this->FeedType === 'Group') {
            $legacyGroupID = $wpdb->get_var("SELECT group_id FROM wp_bp_groups_groupmeta WHERE meta_key='E2ID' AND meta_value='$this->FeedID'");

            if (empty($legacyGroupID)) {
                return [
                    'posts' => [],
                    'total' => 0,
                    'hasMore' => false,
                    'explain' => 'No feed found with that ID.',
                    'explain_data' => [
                        'FeedID' => $this->FeedID,
                        'FeedType' => $this->FeedType,
                    ]
                ];
            }

            // just blank data it
            $userPosts = [
                'activities' => [],
                'total' => 0,
            ];

            $groupPosts = bp_activity_get([
                'filter' => [
                    'object' => 'groups',
                    'primary_id' => (int)$legacyGroupID,
                    'action' => ['activity_update', 'activity_share', 'activity_media_update', 'activity_video_update'],
                ],
                'per_page' => 10,
                'page' => $page,
                'fields' => 'ids',
                'count_total' => true,
            ]);
        } else {
            return [
                'posts' => [],
                'total' => 0,
                'hasMore' => false,
                'explain' => 'No feed found with that ID.',
                'explain_data' => [
                    'FeedID' => $this->FeedID,
                    'FeedType' => $this->FeedType,
                ]
            ];
        }

        // Merge the two arrays
        $allPosts = array_unique(array_merge($userPosts['activities'], $groupPosts['activities']));
        $allPosts = self::GetPosts($allPosts);

        return [
            'posts' => $allPosts,
            'page' => $page,
            'total' => $userPosts['total'] + $groupPosts['total'],
            'hasMore' => $userPosts['total'] + $groupPosts['total'] > ($page * 10),
        ];
    }

    /**
     * Get a (single or list) of activities, formatted for Nextgen
     *
     * @param array $ids
     * @param bool $returnLegacyIDOnly
     * @param bool $dontRecursiveSubContent
     * @return array
     * @throws Exception
     * @todo: STRIP BUDDYPRESS' STUPID FUCKERY, MOTHERFLUFFER! (oh and also move this to a class uwu~)
     */
    public static function GetPosts(array $ids = [], bool $returnLegacyIDOnly = false, bool $dontRecursiveSubContent = false): array
    {
        // Check each ID, if it can't be converted to a number, get the activity_id from meta
        $ids = array_map(function ($id) {
            global $wpdb;

            if (!is_numeric($id)) {
                // Check if stripping the first 4 characters is numeric
                $strippedID = substr($id, 4);

                if (is_numeric($strippedID)) {
                    return $strippedID;
                } else {
                    $sql = "SELECT activity_id FROM wp_bp_activity_meta WHERE meta_key = 'E2ID' AND meta_value = '$id'";
                    return $wpdb->get_results($sql)[0]->activity_id;
                }
            } else {
                return $id;
            }
        }, $ids);

        if ($returnLegacyIDOnly) {
            return $ids;
        }

        if (empty($ids)) {
            return [];
        }

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
                'user' => YipnyapGetMember($post->user_id, null),
                'replies' => [],
                'likes' => count(bp_activity_get_meta($post->id, 'liked_by', false))
            ];

            // Check if in group
            if ($post->component === 'groups') {
                $build['group'] = new Group($post->item_id, true);
            }

            $EditorBlocks = unserialize(bp_activity_get_meta($post->id, 'blocks'));
            if (!empty($EditorBlocks)) {
                $build['content'] = $EditorBlocks;
            } else {
                if (empty($post->content) || $post->content === ' ') {
                    // Delete and continue
                    bp_activity_delete([
                        'id' => $post->id,
                    ]);
                    continue;
                }

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

            // Get media - New
            $mediaObjects = bp_activity_get_meta($post->id, 'objects', false);
            if (!empty($mediaObjects)) {
                foreach ($mediaObjects as $mediaObject) {
                    $build['objects'][] = [
                        'id' => $mediaObject['id'],
                        'url' => YIPNYAP_SUPABASE_URL . '/storage/v1/object/public/users/' . $mediaObject['key'],
                    ];
                }
            }

            // Get legacy reactions & add them to the likes integer
            $legacyReactions = vkreact_bp_get_activity_reactions($post->id);
            foreach ($legacyReactions as $legacyReaction) {
                $build['likes'] = $build['likes'] + $legacyReaction->reaction_count;

                // Filter through & migrate reactions
                foreach ($legacyReaction->users as $reactingUser) {
                    $reactingUser = YipnyapGetMember($reactingUser, null);
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
            } else {
                // Check if the user has liked the post
                $build['likedParent'] = false;
                $likedBy = bp_activity_get_meta($post->id, 'liked_by', false);
                if (!empty($likedBy)) {
                    if (in_array(YipnyapGetMemberE2ID(get_current_user_id()), $likedBy)) {
                        $build['likedParent'] = true;
                    }
                }
            }

            // Check if the post is a share (just check if `_share` exists lol)
            $postIsShare = str_contains($post->type, '_share');
            if ($postIsShare) {
                // Append to `subcontent`
                $subcontent = self::GetPosts([$post->secondary_item_id]);
                $build['subcontent'] = !empty($subcontent) ? $subcontent[0] : null;
                if (!empty($build['subcontent']['subcontent'])) {
                    // Fuck you legacy - Find the last post in the chain.
                    // this probably adds a lot of latency overhead, but whatever.
                    $lastPost = $build['subcontent'];
                    while (!empty($lastPost['subcontent'])) {
                        $lastPost = $lastPost['subcontent'];
                    }
                    $build['subcontent'] = $lastPost;
                }
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
                'user' => YipnyapGetMember($comment->user_id, null),
                'content' => html_entity_decode(stripcslashes($comment->content)),
            ];

            // Check if they liked the parent
            if (!empty($parentID)) {
                $liked = in_array(YipnyapGetMemberE2ID($comment->user_id), bp_activity_get_meta($parentID, 'liked_by', false));
                if ($liked) {
                    $buildReply['likedParent'] = true;
                }
            }

            // If logged in, add timestamp
            if (is_user_logged_in()) {
                $buildReply['timestamp'] = strtotime($comment->date_recorded);
            }

            // Get like count
            $buildReply['likes'] = count(bp_activity_get_meta($comment->id, 'liked_by', false));

            // Check if the user has liked the comment
            if (is_user_logged_in()) {
                $buildReply['liked'] = false;
                $likedBy = bp_activity_get_meta($comment->id, 'liked_by', false);
                if (!empty($likedBy)) {
                    if (in_array(YipnyapGetMemberE2ID(get_current_user_id()), $likedBy)) {
                        $buildReply['liked'] = true;
                    }
                }
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

        // Sort by timestamp (newest first)
        if (is_user_logged_in()) {
            usort($build, function ($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });
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
        // Check if the user is logged in
        if (!is_user_logged_in()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to create a post.',
            ];
        }

        // Check if the post is valid
        if (!empty($post['tags']) && count($post['tags']) > 10) {
            return [
                'success' => false,
                'message' => 'You can only have up to 10 tags.',
            ];
        }

        $UserE2ID = get_user_meta(get_current_user_id(), 'E2ID', true);
        if (empty($UserE2ID)) {
            $UserE2ID = LegacyIDToE2ID(get_current_user_id(), 'User');
            update_user_meta(get_current_user_id(), 'E2ID', $UserE2ID);
        }

        // Check if the target is a group
        $goingToGroup = false;
        if (!empty($post['target'])) {
            try {
                $goingToGroup = new Group($post['target'], true);
            } catch (Exception $e) {
                // Just skip
            }
        }

        // Create the post
        $E2ID = E2IDCreate('Post');
        $args = [
            'user_id' => get_current_user_id(),
            'content' => ' ',
            'type' => 'activity_update',
        ];

        if ($goingToGroup !== false) {
            $args['component'] = 'groups';
            $args['item_id'] = $goingToGroup->GroupID;
            $post_id = groups_record_activity($args);
        } else {
            $args['component'] = 'activity';
            $post_id = bp_activity_add($args);
        }

        if (empty($post_id)) {
            $this->abort($post_id);
            return [
                'success' => false,
                'message' => 'Failed to create post.',
            ];
        }

        // Set the E2ID
        bp_activity_update_meta($post_id, 'E2ID', $E2ID);

        // Set the tags
        if (!empty($post['tags'])) {
            bp_activity_update_meta($post_id, 'tags', implode(',', $post['tags']));
        }

        $content = $post['content'];

        // - check all the blocks are valid EditorJS blocks
        if (json_last_error() !== JSON_ERROR_NONE
            || !isset($content['time'])
            || !isset($content['version'])
            || !isset($content['blocks'])
            || !is_numeric($content['time'])
            || !is_string($content['version'])
            || !is_array($content['blocks'])
        ) {
            $this->abort($post_id);
            return [
                'success' => false,
                'message' => 'Invalid JSON.',
            ];
        }

        foreach ($content['blocks'] as $block) {
            if (!isset($block['type'])
                || !isset($block['data'])
                || !is_string($block['type'])
                || !is_array($block['data'])
                || !in_array($block['type'], ['header', 'paragraph', 'list', 'quote', 'code', 'table', 'link'])
            ) {
                $this->abort($post_id);
                return [
                    'success' => false,
                    'message' => 'Invalid JSON.',
                ];
            }
        }

        if (!empty($post['objects'])) {
            foreach ($post['objects'] as $object) {
                if (!isset($object['data'])
                    || !is_string($object['data'])
                ) {
                    $this->abort($post_id);
                    return [
                        'success' => false,
                        'message' => 'An object is invalid.',
                    ];
                } else {
                    $key = SupabaseUploadFromBase64('Post', 'CONTENT_IMAGE', $UserE2ID, $object['data']);
                    if (empty($key) || empty($key['key'])) {
                        $this->abort($post_id);
                        return [
                            'success' => false,
                            'message' => 'Failed to upload an object.',
                        ];
                    } else {
                        bp_activity_add_meta($post_id, 'objects', [
                            'id' => $key['id'],
                            'key' => $key['key'],
                        ]);
                    }
                }
            }
        }

        // serialize the content
        bp_activity_add_meta($post_id, 'blocks', serialize($content));

        return [
            'success' => true,
            'data' => $this->GetPosts([$post_id])[0],
        ];
    }

    /**
     * Create a comment
     *
     * @param string $PostE2
     * @param string $content
     * @param string|null $ParentCommentE2
     * @return array
     * @throws Exception
     */
    public static function CreateComment(string $PostE2, string $content, string|null $ParentCommentE2 = null): array
    {
        if (!is_user_logged_in()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to comment.',
            ];
        }

        // Check if the post exists
        $post = FeedMixer::GetPosts([$PostE2], true);
        if (empty($post)) {
            return [
                'success' => false,
                'message' => 'Post not found.',
            ];
        }

        // Check if content is valid - less than 512 characters, and not empty
        if (strlen($content) > 512) {
            return [
                'success' => false,
                'message' => 'Comment too long.',
            ];
        }
        if (empty($content)) {
            return [
                'success' => false,
                'message' => 'Comment cannot be empty.',
            ];
        }

        // Create the comment
        $E2ID = E2IDCreate('Post', 'INTERACTION_HOWLING_ALONGSIDE');
        $comment_id = bp_activity_new_comment([
            'content' => $content,
            'activity_id' => $post[0],
            'parent_id' => $ParentCommentE2 ? FeedMixer::GetPosts([$ParentCommentE2], true)[0] : false,
        ]);

        if ($comment_id === false) {
            return [
                'success' => false,
                'message' => 'Failed to create comment.',
            ];
        }

        // Set the E2ID
        bp_activity_update_meta($comment_id, 'E2ID', $E2ID);

        return [
            'success' => true,
            'message' => 'Comment created.',
            'data' => FeedMixer::GetPosts([$post[0]])[0],
            'commentID' => $E2ID,
        ];
    }

    /**
     * Add a like to a post
     *
     * @param string $PostE2
     * @param string $type
     * @return array
     * @throws Exception
     */
    public static function EditLike(string $PostE2, string $type = 'ADDITION'): array
    {
        global $LogtailServiceLogger;

        if (!is_user_logged_in()) {
            return [
                'success' => false,
                'message' => 'You must be logged in to like a post.',
                'code' => 'E_ACCOUNT_01A101',
            ];
        }

        // Check if the post exists
        $post = self::GetPosts([$PostE2], true);
        if (!is_numeric($post[0])) {
            return [
                'success' => false,
                'message' => 'Post not found, or the post doesn\'t support likes.',
                'code' => 'E_HOWLING_03I100',
            ];
        }

        // Check if the user has already liked the post
        $UserE2 = YipnyapGetMemberE2ID(get_current_user_id());
        if (empty($UserE2)) {
            return [
                'success' => false,
                'message' => 'Failed to get user E2ID.',
                'code' => 'E_ACCOUNT_01A102',
            ];
        }

        $liked = bp_activity_get_meta($post[0], 'liked_by', false);
        if ($type === 'ADDITION') {
            if (!empty($liked)) {
                if (in_array($UserE2, $liked)) {
                    return [
                        'success' => false,
                        'message' => 'You have already liked this post.',
                        'code' => 'E_HOWLING_03I110',
                    ];
                }
            }

            // Add the like
            bp_activity_add_meta($post[0], 'liked_by', $UserE2);
        } elseif ($type === 'DELETION') {
            if (!empty($liked)) {
                if (!in_array($UserE2, $liked)) {
                    return [
                        'success' => false,
                        'message' => 'You haven\'t liked this post.',
                        'code' => 'E_HOWLING_03I120',
                    ];
                }

                // Remove the like
                bp_activity_delete_meta($post[0], 'liked_by', $UserE2);

                // Check if the likes suddenly lost more than 1 like
                $likedNew = bp_activity_get_meta($post[0], 'liked_by', false);
                if (count($likedNew) === 0 && count($liked) > 1) {
                    // if it did, recover and debug
                    foreach ($liked as $like) {
                        bp_activity_add_meta($post[0], 'liked_by', $like);
                    }

                    // report it
                    $likeCount = count($liked);
                    $LogtailServiceLogger->alert("Post like {$type} on {$post[0]}: FAIL: Removal caused sudden loss of {$likeCount} likes. Recovered; Inherently failed.", [
                        'userE2' => $UserE2,
                        'userIID' => get_current_user_id(),
                        'post' => $post[0],
                        'likes' => $liked,
                        'likesNew' => $likedNew,
                    ]);

                    return [
                        'success' => false,
                        'message' => 'Deletion technically succeeded, but the post suddenly lost all likes. Likes were recovered and the incident was reported.',
                        'code' => 'E_HOWLING_03I121',
                    ];
                }

            } else {
                return [
                    'success' => false,
                    'message' => 'You haven\'t liked this post.',
                    'code' => 'E_HOWLING_03I120',
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Invalid type.',
                'code' => 'E_HOWLING_03I101',
            ];
        }

        $likes = bp_activity_get_meta($post[0], 'liked_by', false);
        if (empty($likes)) {
            $likes = [];
        }

        $response = [
            'success' => true,
            'data' => [
                'likes' => count($likes),
            ],
            'type' => $type,
            'id' => $post[0],
        ];

        $LogtailServiceLogger->info("Post like {$response['type']} on {$response['id']}: new count {$response['data']['likes']}", $response);

        return $response;
    }

    /**
     * @throws Exception
     */
    public static function DeletePost($post_id)
    {
        $post = FeedMixer::GetPosts([$post_id], true);
        $post = bp_activity_get([
            'in' => $post[0]
        ])['activities'][0];

        if (empty($post)) {
            return [
                'success' => false,
                'status' => 404,
                'message' => 'Post not found.',
            ];
        }

        if ($post->user_id !== get_current_user_id()) {
            return [
                'success' => false,
                'status' => 403,
                'message' => 'You don\'t have permission to delete this post, ' . $post->user_id
            ];
        }

        // delete the bp post
        $success = bp_activity_delete([
            'id' => $post->id,
        ]);

        if ($success === false) {
            return [
                'success' => false,
                'status' => 500,
                'message' => 'Failed to delete post.',
            ];
        }

        return [
            'success' => true,
        ];
    }

    function abort($post_id): void
    {
        // delete the bp post
        bp_activity_delete([
            'id' => $post_id,
        ]);
    }
}