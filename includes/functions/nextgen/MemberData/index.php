<?php
/**
 * Initialise bitwise arrays
 */
$GetMemberBit = [
    'link' => 1,
    'rank' => 2,
    'ui_skin' => 4,
    'online_count' => 8,
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
            } elseif (!$skipErrorReturn) {
                wp_send_json([
                    'code' => 404,
                    'error' => 'Member not found.',
                ]);
            } else {
                return 0;
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
    global $GetMemberBit;

    /**
     * Check if member_id is an ID, or a username. If it's a username, get the ID.
     */
    $member_id = YipnyapFetchMemberID($member_id, true);

    if ($member_id === get_current_user_id()) {
        $isSelf = true;
    }

    $memberOld = yipnyap_members_get(['include' => [$member_id]]);
    if (empty($memberOld)) {
        return [
            'code' => 404,
            'error' => 'Member not found.',
        ];
    } else {
        $memberOld = $memberOld[0];
    }

    $onlineRequest = new WP_REST_Request('GET', '/buddypress/v1/members');
    $onlineRequest->set_param('type', 'online');
    $onlineRequest->set_param('populate_extras', 0);
    $onlineResponse = rest_do_request($onlineRequest);

    $UserE2ID = YipnyapGetMemberE2ID($member_id);

    // TODO: Deperecate "mention_name" in the future.
    $member = [
        'id' => $memberOld['id'],
        'E2ID' => $UserE2ID,
        'display_name' => $memberOld['name'],
        'username' => $memberOld['mention_name'],
        'avatar' => $memberOld['avatar_url'],
        'header' => yipnyap_member_get_cover_url($member_id),
        'followers' => count(bp_follow_get_followers([
            'user_id' => $member_id,
        ])),
        'following' => count(bp_follow_get_following([
            'user_id' => $member_id,
        ])),
        'posts' => YipnyapGetMemberActivityCount($member_id),
    ];
    $member['header'] = str_contains($member['header'], 'default-cover') ? '' : $member['header'];

    /**
     * Check if member is online, then add "online" to the member array.
     */
    if ($getOnline) {
        $member['online'] = false;
        foreach ($onlineResponse->data as $onlineMember) {
            if ($onlineMember['id'] === $member_id) {
                $member['online'] = true;
                break;
            }
        }
    }

    /**
     * Check if member is verified, then add "verified" to the member array.
     */
    if ($memberOld['verified']) {
        $member['verified'] = true;
    }

    $profile_data = [
        'profile_data' => yipnyap_member_get_xprofile_data($member_id),
    ];

    /**
     * Check if Bio exists, and if so, add it to the array.
     */
    $memberBio = yipnyap_members_xprofile_get_field_value($profile_data, 'Profile_Bio_About');
    if ($memberBio) {
        $member['bio'] = $memberBio;
    }

    $memberExtURL = yipnyap_members_xprofile_get_field_value($profile_data, 'Profile_Bio_Web');
    if ($memberExtURL) {
        $member['exturl'] = $memberExtURL;
    }

    /**
     * Check if member is "me", then add UI Privacy & Security to the member array.
     */
    if ($isSelf) {
        $uiPrivacy = strtolower(yipnyap_members_xprofile_get_field_value($profile_data, 'Account_Info_UI Privacy and Security'));
        $unicornEngine = get_option('unicorn_engine');
        $member['ui_privacy'] = [
            'hide_custom_ui_notice' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['hide_customised_ui_str']),
            'disallow_bg_render' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_bg_render_str']),
            'disallow_palette_render' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_palette_render_str']),
        ];

        $member['tgid'] = get_user_meta($member_id, 'tgid', true);
        $member['secureIDLevel'] = get_user_meta($member_id, 'SecureID:Level', true);
        $member['dipswitch'] = json_decode(get_user_meta($member_id, 'dipswitch', true), true);
    }

    /**
     * Check if bitwise has "ui_skin", add Unicorn Engine
     */
    if ($bitwise & $GetMemberBit['ui_skin']) {
        $member['ui_skin'] = [
            'primary' => yipnyap_members_xprofile_get_field_value($profile_data, 'Account_Info_Profile Primary Accent'),
            'background' => yipnyap_members_xprofile_get_field_value($profile_data, 'Account_Info_Profile Background'),
        ];
    }

    /**
     * Check if bitwise has "online_count", add currently online count
     */
    if ($bitwise & $GetMemberBit['online_count']) {
        $onlineCount = count($onlineResponse->data);

        // If the count is less than or equal to 3, generate a random online count based on the current time.
        if ($onlineCount <= 3) {
            $originalOnlineCount = $onlineCount;
            // Add up current date, hour, and minute, then divide by 10.
            $onlineCount = (intval(date('d')) + intval(date('H')) + intval(date('i'))) / 20;
            // Round the number to the nearest 10.
            $onlineCount = round($onlineCount);
            // Add the original online count to the new online count.
            $onlineCount += $originalOnlineCount;
        }

        $member['online_count'] = $onlineCount;
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
 *
 * @param string|int $member_id Member ID
 * @return array Member's groups
 * @since ui1
 */
function YipnyapGetMemberGroups(string|int $member_id, array $query = ['fields' => 'all']): array {
    $member_id = YipnyapFetchMemberID($member_id);
    $groups = [];

    $gp_groups = groups_get_groups([
        'user_id' => $member_id,
    ]);

    foreach ($gp_groups['groups'] as $gp_group) {
        // check if fields should only include IDs
        if ($query['fields'] === 'ids') {
            $groups[] = $gp_group->id;
        } else {
            // check if int, if so, true.
            $is_admin = is_int(groups_is_user_admin($member_id, $gp_group->id));
            $is_mod = is_int(groups_is_user_mod($member_id, $gp_group->id));
            $is_member = is_int(groups_is_user_member($member_id, $gp_group->id));
            $groups[] = [
                'id' => $gp_group->id,
                'name' => $gp_group->name,
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
                'is_admin' => $is_admin,
                'is_mod' => $is_mod,
                'is_member' => $is_member,
            ];
        }
    }

    return $groups;
}

/**
 * Get member's friends
 *
 * @param string|int $member_id Member ID
 * @return array Member's friends
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
