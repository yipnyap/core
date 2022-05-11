<?php
/**
 * Functions - BuddyPress - Activity - Filters
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

if (!function_exists('yipnyap_filter_activity_activity_update_action')) {
    /**
     * Custom filter for activity activity_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_filter_activity_activity_update_action($action, $activity)
    {
        $action = ''; //esc_html_x('posted an update', 'Activity Update Action - Text', 'yipnyap');

        return $action;
    }
}

add_filter('bp_activity_new_update_action', 'yipnyap_filter_activity_activity_update_action', 10, 2);

if (!function_exists('yipnyap_filter_activity_update_action_group')) {
    /**
     * Custom filter for group activity_update action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_filter_activity_update_action_group($action, $activity)
    {
        $action = esc_html_x('in', 'Activity Update Group Action - Text', 'yipnyap');

        return $action;
    }
}

add_filter('bp_groups_format_activity_action_group_activity_update', 'yipnyap_filter_activity_update_action_group', 10, 2);


if (!function_exists('yipnyap_filter_activity_action_friendship_created')) {
    /**
     * Custom filter for group friendship_created / friendship_accepted action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_filter_activity_action_friendship_created($action, $activity)
    {
        $action = esc_html_x('are now friends', 'Activity Friendship Created Action - Text', 'yipnyap');

        return $action;
    }
}

add_filter('bp_friends_format_activity_action_friendship_created', 'yipnyap_filter_activity_action_friendship_created', 10, 2);
add_filter('bp_friends_format_activity_action_friendship_accepted', 'yipnyap_filter_activity_action_friendship_created', 10, 2);

if (!function_exists('yipnyap_filter_activity_action_joined_group')) {
    /**
     * Action string format for the joined_group action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_filter_activity_action_joined_group($action, $activity)
    {
        $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

        // remove first anchor, which contains user fullname
        return preg_replace($pattern, '', $action, 1);
    }
}

add_filter('bp_groups_format_activity_action_joined_group', 'yipnyap_filter_activity_action_joined_group', 10, 2);

if (!function_exists('yipnyap_filter_activity_action_created_group')) {
    /**
     * Action string format for the created_group action
     *
     * @param string $action Action string
     * @param Object $activity Activity item object
     * @return string
     */
    function yipnyap_filter_activity_action_created_group($action, $activity)
    {
        $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

        // remove first anchor, which contains user fullname
        return preg_replace($pattern, '', $action, 1);
    }
}

add_filter('groups_activity_created_group_action', 'yipnyap_filter_activity_action_created_group', 10, 2);

if (!function_exists('yipnyap_gamipress_filter_activity_action_earned_achievement')) {
    /**
     * Action string format for GamiPress activity_update activities
     */
    function yipnyap_gamipress_filter_activity_action_earned_achievement($activity, $user_id, $post_id, $trigger_type, $site_id, $args)
    {
        if (!array_key_exists('action', $activity)) {
            return $activity;
        }

        $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

        // remove first anchor, which contains user fullname
        $activity['action'] = preg_replace($pattern, '', $activity['action'], 1);

        return $activity;
    }
}

add_filter('gamipress_bp_activity_details', 'yipnyap_gamipress_filter_activity_action_earned_achievement', 15, 6);

if (!function_exists('yipnyap_filter_activity_action_new_avatar')) {
    /**
     * Action string format for new_avatar type
     */
    function yipnyap_filter_activity_action_new_avatar($action, $activity)
    {
        $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

        // remove first anchor, which contains user fullname
        return preg_replace($pattern, '', $action, 1);
    }
}

add_filter('bp_xprofile_format_activity_action_new_avatar', 'yipnyap_filter_activity_action_new_avatar', 10, 2);

?>
