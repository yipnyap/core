<?php
/**
 * Functions - BuddyPress - Member - Filters
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

if (!function_exists('yipnyap_member_gravatar_disable')) {
    /**
     * Disable Gravatar
     */
    function yipnyap_member_gravatar_disable()
    {
        return true;
    }
}

add_filter('bp_core_fetch_avatar_no_grav', 'yipnyap_member_gravatar_disable');

if (!function_exists('yipnyap_set_default_member_avatar')) {
    /**
     * Set default member avatar
     */
    function yipnyap_set_default_member_avatar()
    {
        $members_default_avatar_url = yipnyap_get_default_member_avatar_url();

        return $members_default_avatar_url;
    }
}

add_filter('bp_core_default_avatar_user', 'yipnyap_set_default_member_avatar');

if (!function_exists('yipnyap_members_cover_image_setup')) {
    /**
     * Setup member cover preferred image size
     */
    function yipnyap_members_cover_image_setup($settings = [])
    {
        // dimension settings
        $settings['width'] = 1184;
        $settings['height'] = 300;

        return $settings;
    }
}

add_filter('bp_before_members_cover_image_settings_parse_args', 'yipnyap_members_cover_image_setup', 10, 1);

?>
