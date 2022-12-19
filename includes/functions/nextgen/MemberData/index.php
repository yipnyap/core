<?php
/**
 * Initialise bitwise arrays
 */
$GetMemberBit = [
    'link' => 1,
    'rank' => 2,
    'ui_skin' => 4,
];

/**
 * Get all possible bitwise keys and values and return as array
 *
 * @return array Bitwise values
 * @since hk15
 */
function YipnyapGetBitwiseValues(): array
{
    global $GetMemberBit;

    return [
        'GetMember' => $GetMemberBit,
    ];
}

/**
 * Get member data by ID
 *
 * @param int|string $member_id Member ID.
 * @param int $bitwise
 * @return array Member data.
 * @since hk15
 *
 * @see yipnyap_members_get
 */
function YipnyapGetMember(int|string $member_id, int $bitwise = 0x0): array
{
    global $GetMemberBit;

    /**
     * Check if member_id is an ID, or a username. If it's a username, get the ID.
     */
    if (!preg_match('/^[0-9]*$/', $member_id)) {
        $member_id = str_replace('@', '', $member_id);

        /**
         * Check if ID is "me", and if so, get the logged in user's ID.
         */
        if ($member_id === 'me') {
            $isSelf = true;
            $member_id = get_current_user_id();
        } else {
            $member_by_login = get_user_by('login', $member_id);
            if ($member_by_login) {
                $member_id = $member_by_login->ID;
            }
        }
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

    // TODO: Deperecate "mention_name" in the future.
    $member = [
        'id' => $memberOld['id'],
        'display_name' => $memberOld['name'],
        'username' => $memberOld['mention_name'],
        'avatar' => $memberOld['avatar_url'],
        'header' => yipnyap_member_get_cover_url($member_id),
        'followers' => count(bp_follow_get_followers(array(
            'user_id' => $member_id
        ))),
        'following' => count(bp_follow_get_following(array(
            'user_id' => $member_id
        ))),
        'posts' => YipnyapGetMemberActivityCount($member_id)
    ];
    $member['header'] = str_contains($member['header'], 'default-cover') ? '' : $member['header'];

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
     * Check if member is "me", then add UI Privacy
     */
    if (isset($isSelf)) {
        $uiPrivacy = strtolower(yipnyap_members_xprofile_get_field_value($profile_data, 'Account_Info_UI Privacy and Security'));
        $unicornEngine = get_option('unicorn_engine');
        $member['ui_privacy'] = [
            'hide_custom_ui_notice' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['hide_customised_ui_str']),
            'disallow_bg_render' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_bg_render_str']),
            'disallow_palette_render' => str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_palette_render_str']),
        ];
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
function YipnyapGetMemberActivityCount(int $member_id, string $type = ''): int
{
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
 * @return array Member data
 * @since hk15
 *
 * @see wp_authenticate, YipnyapGetMember
 */
function YipnyapLoginMember(string|null $username, string|null $password): array
{
    if (empty($username) || empty($password)) {
        return [
            'code' => 400,
            'error' => 'Username and password are required.',
        ];
    }

    $user = wp_authenticate($username, $password);
    if (is_wp_error($user)) {
        return [
            'code' => 401,
            'error' => 'Invalid username or password.',
        ];
    } else {
        $YipnyapUser = YipnyapGetMember($user->ID);
        $result = [
            'code' => 200
        ];
        return array_merge($result, $YipnyapUser);

    }
}
