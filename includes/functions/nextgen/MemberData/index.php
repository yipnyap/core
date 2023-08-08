<?php
use \Firebase\JWT\JWT;
use Yipnyap\Group;

/**
 * Initialise bitwise arrays
 */
$GetMemberBit = [
    'link' => 1,
    'rank' => 2,
    'ui_skin' => 4,
    'online_count' => 8,
    'friends' => 16,
    'groups' => 32,
];

/**
 * Get all possible bitwise keys and values and return as array
 *
 * @return array Bitwise values
 * @since hk15
 */
function YipnyapGetBitwiseValues(): array {
    global $GetMemberBit;

    return [
        'GetMember' => $GetMemberBit,
    ];
}

/**
 * Get member ID if username is provided, otherwise return ID
 *
 * @param int|string $member_id Member ID or username.
 * @return int Member ID.
 * @since hk16-2
 */
function YipnyapFetchMemberID(int|string $member_id, bool $skipErrorReturn = false): int {
    if (!preg_match('/^[0-9]*$/', $member_id)) {
        $member_id = str_replace('@', '', $member_id);

        /**
         * Check if ID is "me", and if so, get the logged in user's ID.
         */
        if ($member_id === 'me') {
            $member_id = get_current_user_id();
        } else {
            $member_by_login = get_user_by('login', $member_id);
            if ($member_by_login) {
                $member_id = $member_by_login->ID;
            } else {
                // Search user meta
                $member_by_meta = get_users([
                    'meta_key' => 'athandle',
                    'meta_value' => $member_id,
                    'fields' => 'ID',
                ]);

                if (count($member_by_meta) > 0) {
                    $member_id = $member_by_meta[0];
                } elseif ($skipErrorReturn) {
                    return 0;
                } else {
                    wp_send_json([
                        'success' => false,
                        'message' => 'Member not found. - ' . $member_id,
                    ], 404);
                }
            }
        }
    }

    return intval($member_id);
}

/**
 * Get member data by ID
 *
 * @param int|string $member_id Member ID.
 * @param int|null $bitwise
 * @param bool $isSelf
 * @param bool $getOnline
 * @return array Member data.
 * @throws Exception
 * @see yipnyap_members_get
 * @since hk15
 *
 */
function YipnyapGetMember(int|string $member_id, int|null $bitwise = 0x0, bool $isSelf = false, bool $getOnline = false): array {
    global $GetMemberBit, $wpdb;

    $supabaseURL = YIPNYAP_SUPABASE_URL;

    if ($member_id === 'me') {
        $isSelf = true;
    }

    /**
     * Check if member_id is an ID, or a username. If it's a username, get the ID.
     */
    $member_id = YipnyapFetchMemberID($member_id, true);

    $memberOld = yipnyap_members_get(['include' => [$member_id]]);
    if (empty($memberOld)) {
        throw new Exception('ENOTFOUND', 404);
    } else {
        $memberOld = $memberOld[0];
    }

    $UserE2ID = YipnyapGetMemberE2ID($member_id);

    $memberOld['avatar_url'] = str_replace('/yipnyap.me/', '/api.yipnyap.me/', $memberOld['avatar_url']);
    $member = [
        'id' => $memberOld['id'],
        'E2ID' => $UserE2ID,
        'display_name' => $memberOld['name'],
        'username' => $memberOld['mention_name'],
        'avatar' => $memberOld['avatar_url'],
        'followers' => count(bp_follow_get_followers([
            'user_id' => $member_id,
        ])),
        'following' => count(bp_follow_get_following([
            'user_id' => $member_id,
        ])),
        'posts' => YipnyapGetMemberActivityCount($member_id),
        'privacy' => [
            'isAD' => get_user_meta($member_id, 'privacy:isAD', true) === 'true',
        ],
    ];

    $avatar = get_user_meta($member_id, 'avatar', true);
    $header = get_user_meta($member_id, 'header', true);
    if (!empty($header)) {
        $member['header'] = $supabaseURL . '/storage/v1/object/public/users/' . $header;

        // Remove the old one
        bp_attachments_delete_file([
            'item_id' => $member_id,
            'object_dir' => 'members',
        ]);
    } else {
        $member['header'] = bp_attachments_get_attachment('url', [
            'item_id' => $member_id,
            'object_dir' => 'members',
        ]);

        $member['header'] = str_replace('/yipnyap.me/', '/api.yipnyap.me/', $member['header']);
    }

    if (!empty($avatar)) $member['avatar'] = $supabaseURL . '/storage/v1/object/public/users/' . $avatar;

    $member['permaname'] = $member['username'];
    $athandle = get_user_meta($member_id, 'athandle', true);
    if (!empty($athandle)) {
        $member['username'] = $athandle;
    }

    $profile_data = [
        'profile_data' => yipnyap_member_get_xprofile_data($member_id),
    ];

    /**
     * Check if Bio exists, and if so, add it to the array.
     */
    $memberBio = get_user_meta($member_id, 'bio', true);
    $memberBioOld = yipnyap_members_xprofile_get_field_value($profile_data, 'Profile_Bio_About');
    if ($memberBio) {
        $member['bio'] = $memberBio;
    } elseif ($memberBioOld) {
        $member['bio'] = $memberBioOld;
    }

    /**
     * Check if member is "me", then add UI Privacy & Security to the member array.
     */
    if ($isSelf) {
        $member['tgid'] = get_user_meta($member_id, 'tgid', true);
        $member['secureIDLevel'] = get_user_meta($member_id, 'SecureID:Level', true);
        $member['dipswitch'] = json_decode(get_user_meta($member_id, 'dipswitch', true), true);
        $member['privacy']['showNSFW'] = get_user_meta($member_id, 'privacy:showNSFW', true) === 'true';

        // Get the latest post of the @yipnyap account
        $yipnyapAccountID = YipnyapFetchMemberID('yipnyap', true);
        $latestPost = bp_activity_get([
            'filter' => [
                'user_id' => [$yipnyapAccountID],
            ],
            'per_page' => 1,
        ])['activities'][0]->id;
        $latestPost = Yipnyap\FeedMixer::GetPosts([$latestPost])[0];
        $member['yipnyap_notice'] = $latestPost;

        // Get events, based on `event` meta_key from database
        $eventsActivity = $wpdb->get_var("SELECT activity_id FROM wp_bp_activity_meta WHERE meta_key='event'");

        foreach ($eventsActivity as $eventActivity) {
            $event = bp_activity_get_meta($eventActivity, 'event');
            $member['events'][] = [
                'title' => $event ?: 'General Event',
                'post' => Yipnyap\FeedMixer::GetPosts([$eventActivity], false, true)[0],
            ];
        }

        // Find group with `featured` meta
        $featuredGroups = $wpdb->get_var("SELECT group_id FROM wp_bp_groups_groupmeta WHERE meta_key='featured'");
        if (empty($featuredGroups)) $featuredGroups = [10,11,'yipnyap-feedback',13,15,16,17,18,19,20];

        foreach ($featuredGroups as $groupID) {
            try {
                $group = new Group($groupID, true);
                $member['featured_groups'][] = $group->GroupMeta;
            } catch (\Throwable $th) {
                continue;
            }
        }
    }

    /**
     * Check if bitwise has "ui_skin", add Unicorn Engine
     */
    if ($bitwise & $GetMemberBit['ui_skin']) {
        $member['theme'] = [
            'background' => get_user_meta($member_id, 'theme:background', true),
        ];

        // check if shareAccent is true, if so, get their accent from dipswitch
        if (get_user_meta($member_id, 'theme:shareAccent', true)) {
            $dipswitch = json_decode(get_user_meta($member_id, 'dipswitch', true), true);
            $member['theme']['accent'] = strtolower($dipswitch['accent']) ?? 'blue';
        }
    }

    /**
     * Check if bitwise has "friends"
     */
    if ($bitwise & $GetMemberBit['friends']) {
        $member['friends'] = YipnyapGetMemberFriends($member_id);
    }

    /**
     * Check if bitwise has "groups"
     */
    if ($bitwise & $GetMemberBit['groups']) {
        $member['groups'] = [];
        $groups = groups_get_user_groups($member_id);
        foreach ($groups['groups'] as $group) {
            $group = new Group($group, true);
            $member['groups'][] = $group->GroupMeta;
        }
    }

    /**
     * Compare bitwise with $GetMemberBit for each key.
     * If the bitwise is set, then add the key to the member array.
     */
    foreach ($GetMemberBit as $key => $value) {
        if (($bitwise & $value) && isset($memberOld[$key])) {
            $member[$key] = $memberOld[$key];
        }
    }

    return $member;
}

/**
 * Update member data
 *
 * @param int|string $member_id Member ID.
 * @param array $data Member data.
 * @return array Member data.
 * @throws Exception
 */
function YipnyapUpdateMember(int|string $member_id, array $data): array
{
    $member_id = YipnyapFetchMemberID($member_id);

    if (!empty($data['avatar'])) {
        $key = SupabaseUploadFromBase64('Post', 'SETTING_AVATAR', $member_id, $data['avatar']);

        update_user_meta($member_id, 'avatar', $key['key']);
    }

    if (!empty($data['header'])) {
        $key = SupabaseUploadFromBase64('Post', 'SETTING_HEADER', $member_id, $data['header']);

        update_user_meta($member_id, 'header', $key['key']);
    }

    // Save it all
    if (!empty($data['display_name'])) wp_update_user([
        'ID' => $member_id,
        'display_name' => $data['display_name'],
    ]);

    // @TODO: There must be a better way.... right?
    if (!empty($data['bio'])) update_user_meta($member_id, 'bio', $data['bio']);
    if (!empty($data['athandle']) && $data['athandle'] !== get_user_meta($member_id, 'athandle', true)) {
        // Check if it's taken by someone's username or athandle
        $taken = YipnyapFetchMemberID($data['athandle'], true);
        if ($taken === $member_id) $taken = false;
        if ($taken) return [
            'success' => false,
            'error' => 'athandle_taken',
            'message' => 'That handle is taken by someone else, or reserved as their permaname.',
        ];

        update_user_meta($member_id, 'athandle', $data['athandle']);
    }
    if (!empty($data['privacy'])) {
        $privacy = $data['privacy'];
        if (!empty($privacy['showNSFW'])) update_user_meta($member_id, 'privacy:showNSFW', $privacy['showNSFW']);
        if (!empty($privacy['isAD'])) update_user_meta($member_id, 'privacy:isAD', $privacy['isAD']);
    }

    if (!empty($data['theme'])) {
        $theme = $data['theme'];
        if (!empty($theme['background'])) {
            // Allows hex, rgb, rgba, hsl, hsla, url(), and linear-gradient().
            // I'm sorry for this regex.
            // Maybe there's a better way to do this?
            if (!preg_match('/^(#([0-9a-f]{3}){1,2}|rgb\(\d{1,3},\s?\d{1,3},\s?\d{1,3}\)|rgba\(\d{1,3},\s?\d{1,3},\s?\d{1,3},\s?\d(\.\d)?\)|hsl\(\d{1,3},\s?\d{1,3}%,\s?\d{1,3}%\)|hsla\(\d{1,3},\s?\d{1,3}%,\s?\d{1,3}%,\s?\d(\.\d)?\)|url\(.+\)|linear-gradient\(.+\))$/i', $theme['background'])) return [
                'success' => false,
                'error' => 'invalid_background',
                'message' => 'Background must be a valid CSS color or image.',
            ];
            update_user_meta($member_id, 'theme:background', $theme['background']);
        }
        // check if bool true/false, nothing else
        if (isset($theme['shareAccent'])) {
            if ($theme['shareAccent']) {
                update_user_meta($member_id, 'theme:shareAccent', true);
            } else {
                delete_user_meta($member_id, 'theme:shareAccent');
            }
        }
    }

    return [
        'success' => true,
        'data' => YipnyapGetMember($member_id),
    ];
}

/**
 * Get member activity count
 *
 * @param int $member_id Member ID.
 * @return int Activity count.
 * @since hk15
 */
function YipnyapGetMemberActivityCount(int $member_id, string $type = ''): int {
    global $wpdb;

    $table = buddypress()->activity->table_name;
    $where_conditions = [];
    $where_conditions[] = $wpdb->prepare('user_id = %d', $member_id);
    if ($type) {
        $where_conditions[] = $wpdb->prepare('type = %s', $type);
    }

    $whe_sql = join(' AND ', $where_conditions);

    return absint($wpdb->get_var("SELECT count(DISTINCT id) FROM {$table} WHERE {$whe_sql}"));
}

/**
 * Login member based on username and password
 *
 * @param string|null $username Username
 * @param string|null $password Password
 * @param bool|null $remember Remember
 * @param string|null $otp OTP
 * @return array Member data
 * @throws Exception
 * @see wp_authenticate, YipnyapGetMember
 * @since hk15
 */
function YipnyapLoginMember(string|null $username, string|null $password, string|null $otp = null, bool|null $remember = null): array {
    if (empty($username) || empty($password)) {
        return [
            'success' => false,
            'message' => 'Username and password are required.',
        ];
    }

    $user = wp_authenticate($username, $password);
    if (is_wp_error($user)) {
        return [
            'success' => false,
            'message' => 'Invalid username or password.',
        ];
    } else {
        $YipnyapUser = YipnyapGetMember($user->ID, null, true);

        if ($YipnyapUser['tgid']) {
            $OTPResult = YipnyapCheckOTP($YipnyapUser, $otp);
            if (!$OTPResult['success']) {
                // If OTP is not correct, return the error message.
                return $OTPResult;
            }
        }

        // Everything should be correct - check for E2, if it's not set, then set it.
        $CurrentE2ID = get_user_meta($user->ID, 'E2ID', true);
        if (empty($CurrentE2ID)) {
            $E2ID = E2IDCreate('User');
            update_user_meta($user, 'E2ID', $E2ID);
        }

        // Login user to WordPress
        wp_signon([
            'user_login' => $username,
            'user_password' => $password,
            'remember' => $remember,
        ], true);
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, $remember);

        // Make a JWT token
        $token = JWT::encode([
            'iss' => get_site_url(),
            'aud' => get_site_url(),
            'iat' => time(),
            'exp' => time() + 60 * 60 * 24 * 7,
            'data' => [
                'id' => $user->ID,
            ],
        ], YIPNYAP_SUPABASE_SERVICE_KEY);

        $YipnyapUser['token'] = $token;

        return [
            'success' => true,
            'user' => $YipnyapUser,
        ];

    }
}

/**
 * Check OTP, send one if not exists.
 *
 * @param $YipnyapUser
 * @param string|null $otp
 * @return array ['success' => bool, 'message' => string] - success is true only if OTP is correct.
 * @throws Exception
 */
function YipnyapCheckOTP($YipnyapUser, string|null $otp = null): array {
    // Check if OTP is required
    if (empty($YipnyapUser['tgid'])) {
        return [
            'success' => true,
            'message' => 'No OTP required.',
        ];
    }

    // Ready Telegram
    $tg = new YipnyapTelegram();

    // Check if OTP exists, otherwise generate a code
    $otpCode = false;
    // if $otp is blank, assume that the user was not prompted for OTP yet
    if (!empty($otp)) $otpCode = get_user_meta($YipnyapUser['id'], 'SecureID:OCA', true);
    if (empty($otpCode)) {
        // Generate random string, using the users' security level
        // as the length of the string.
        $secureIDLevel = get_user_meta($YipnyapUser['id'], 'SecureID:Level', true);
        $otpCode = match ($secureIDLevel) {
            'medium' => bin2hex(random_bytes(4)),
            'high' => bin2hex(random_bytes(8)),
            default => rand(100000, 999999), // 6 digits
        };

        // Send OTP to Telegram
        $tg->SendTgToken($otpCode, $YipnyapUser['tgid']);

        update_user_meta($YipnyapUser['id'], 'SecureID:OCA', md5($otpCode));

        return [
            'success' => false,
            'message' => 'OTP is required.',
        ];
    }

    // Check if OTP is correct
    if (md5($otp) !== $otpCode) {
        $tg->SendFailedLogin($YipnyapUser['username'], $YipnyapUser['tgid']);
        delete_user_meta($YipnyapUser['id'], 'SecureID:OCA');

        return [
            'success' => false,
            'message' => 'Invalid OTP.',
        ];
    } else {
        // Delete OTP
        delete_user_meta($YipnyapUser['id'], 'SecureID:OCA');
        $tg->SendSuccessfulLogin($YipnyapUser['username'], $YipnyapUser['tgid']);

        return [
            'success' => true,
        ];
    }
}

/**
 * Get member's badges
 *
 * @param string|int $member_id Member ID
 * @return array Member's badges
 * @since hk16-2
 */
function YipnyapGetMemberBadges(string|int $member_id): array {
    $member_id = YipnyapFetchMemberID($member_id);
    $badges = [];

    $gp_achievements = gamipress_get_achievements([
        'post_type' => 'badge',
    ]);

    $member_achievements = gamipress_get_user_achievements([
        'user_id' => $member_id,
        'achievement_type' => 'badge',
    ]);

    // Convert $member_achievements to array of achievement IDs
    $member_achievements = array_map(function ($achievement) {
        return $achievement->ID;
    }, $member_achievements);

    foreach ($gp_achievements as $gp_achievement) {
        $complete = in_array($gp_achievement->ID, $member_achievements);
        if ($complete) {
            $badgeBuild = [
                'id' => $gp_achievement->ID,
                'image' => get_post(get_post_thumbnail_id($gp_achievement->ID))->guid,
            ];

            $badgeMeta = [
                'name' => $gp_achievement->post_title,
                'description' => wp_strip_all_tags($gp_achievement->post_content),
            ];

            if (str_starts_with($gp_achievement->post_title, '🙈')) {
                $badgeBuild['secret'] = true;
            } elseif (str_starts_with($gp_achievement->post_title, '✨')) {
                $badgeBuild['deluxe'] = true;
                $badgeBuild = array_merge($badgeBuild, $badgeMeta);
            } else {
                $badgeBuild = array_merge($badgeBuild, $badgeMeta);
            }

            $badges[] = $badgeBuild;
        }
    }

    return $badges;
}

/**
 * Get member's groups
 * @TODO This is now just a general group find function. Need to move this elsewhere
 *
 * @param array $query Query to find groups
 * @return array Member's groups
 * @since ui1
 */
function YipnyapGetGroups(array $query = ['fields' => 'all']): array {
    $groups = [];

    $query = array_merge([
        'fields' => 'all',
        'per_page' => 100,
    ], $query);

    if (!empty($query['user_id'])) $query['user_id'] = YipnyapFetchMemberID($query['user_id']);
    $gp_groups = groups_get_groups($query);

    foreach ($gp_groups['groups'] as $gp_group) {
        // check if fields should only include IDs
        if ($query['fields'] === 'ids') {
            $groups[] = $gp_group->id;
        } else {
            $groupBuild = [
                'id' => $gp_group->id,
                'name' => $gp_group->name,
                'slug' => $gp_group->slug,
                'description' => html_entity_decode($gp_group->description),
                'avatar' => bp_core_fetch_avatar([
                    'item_id' => $gp_group->id,
                    'object' => 'group',
                    'type' => 'full',
                    'html' => false,
                ]),
                'banner' => bp_attachments_get_attachment('url', [
                    'item_id' => $gp_group->id,
                    'object_dir' => 'groups',
                ]),
                'member_count' => $gp_group->total_member_count,
            ];

            $groupBuild['avatar'] = str_replace('/yipnyap.me/', '/api.yipnyap.me/', $groupBuild['avatar']);
            $groupBuild['banner'] = str_replace('/yipnyap.me/', '/api.yipnyap.me/', $groupBuild['banner']);

            if (get_current_user_id()) {
                $groupBuild['is_admin'] = is_int(groups_is_user_admin($query['user_id'], $gp_group->id));
                $groupBuild['is_mod'] = is_int(groups_is_user_mod($query['user_id'], $gp_group->id));
                $groupBuild['is_member'] = is_int(groups_is_user_member($query['user_id'], $gp_group->id));
            }

            $groups[] = $groupBuild;
        }
    }

    return $groups;
}

/**
 * Get member's friends
 *
 * @param string|int $member_id Member ID
 * @return array Member's friends
 * @throws Exception
 * @since ui1
 */
function YipnyapGetMemberFriends(string|int $member_id): array {
    $member_id = YipnyapFetchMemberID($member_id);
    $friends = [];

    $gp_friends = friends_get_friend_user_ids($member_id);

    foreach ($gp_friends as $gp_friend) {
        $friends[] = YipnyapGetMember($gp_friend, null, false, true);
    }

    return $friends;
}

/**
 * Get member's E2ID
 *
 * @param string|int $member_id Member ID
 * @return string Member's E2ID
 * @throws Exception
 */
function YipnyapGetMemberE2ID(string|int $member_id): string
{
    // Check if it's already an E2ID
    if (str_starts_with($member_id, '01')) {
        return $member_id;
    }

    $member_id = YipnyapFetchMemberID($member_id);
    $UserE2ID = get_user_meta($member_id, 'E2ID', true);

    if (empty($UserE2ID)) {
        $UserE2ID = E2IDCreate('User');
        update_user_meta($member_id, 'E2ID', $UserE2ID);
    }

    return $UserE2ID;
}
