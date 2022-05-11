<?php
/**
 * Functions - BuddyPress - Group - Filters
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

if (!function_exists('yipnyap_group_cover_image_setup')) {
    /**
     * Setup group cover preferred image size
     */
    function yipnyap_group_cover_image_setup($settings = [])
    {
        // dimension settings
        $settings['width'] = 1184;
        $settings['height'] = 300;

        return $settings;
    }
}

add_filter('bp_before_groups_cover_image_settings_parse_args', 'yipnyap_group_cover_image_setup', 10, 1);

if (!function_exists('yipnyap_set_default_group_avatar')) {
    /**
     * Set default group avatar
     */
    function yipnyap_set_default_group_avatar()
    {
        $groups_default_avatar_url = yipnyap_get_default_group_avatar_url();

        return $groups_default_avatar_url;
    }
}

add_filter('bp_core_default_avatar_group', 'yipnyap_set_default_group_avatar');

?>
