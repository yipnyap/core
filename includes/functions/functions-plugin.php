<?php
/**
 * Yipnyap PLUGIN functions
 *
 * @since 1.0.0
 */

/**
 * Returns required plugins by the theme.
 *
 * @return array $required_plugins
 */
function yipnyap_plugin_get_required_plugins()
{
    $required_plugins = [
        'buddypress' => [
            'plugin_name' => 'buddypress'
        ],
        'bp-better-messages' => [
            'plugin_name' => 'bp-better-messages'
        ],
        'bp-verified-member' => [
            'plugin_name' => 'bp-verified-member'
        ],
        'bbpress' => [
            'plugin_name' => 'bbpress'
        ],
        'gamipress' => [
            'plugin_name' => 'gamipress'
        ],
        'gamipress-buddypress-integration' => [
            'plugin_name' => 'gamipress-buddypress-integration',
        ],
        'gamipress-bbpress-integration' => [
            'plugin_name' => 'gamipress-bbpress-integration'
        ],
        'yipnyap-buddypress-extension' => [
            'plugin_name' => 'yipnyap-buddypress-extension'
        ],
        'vkreact' => [
            'plugin_name' => 'vkreact'
        ],
        'vkreact-buddypress' => [
            'plugin_name' => 'vkreact-buddypress'
        ],
        'vkmedia' => [
            'plugin_name' => 'vkmedia'
        ],
        'yipnyap-widgets' => [
            'plugin_name' => 'yipnyap-widgets'
        ],
        'yipnyap-metaboxes' => [
            'plugin_name' => 'yipnyap-metaboxes'
        ]
    ];

    return $required_plugins;
}

/**
 * Check if a plugin is active.
 *
 * @param string $plugin PLugin name.
 * @return bool   $is_active      True if plugin is active, false otherwise.
 */
function yipnyap_plugin_is_active($plugin)
{
    switch ($plugin) {
        case 'buddypress':
            $is_active = function_exists('buddypress');
            break;
        case 'bp-verified-member':
            $is_active = class_exists('BP_Verified_Member');
            break;
        case 'bbpress':
            $is_active = class_exists('bbPress');
            break;
        case 'bp-better-messages':
            $is_active = class_exists('BP_Better_Messages');
            break;
        case 'gamipress':
            $is_active = function_exists('GamiPress');
            break;
        case 'gamipress-buddypress-integration':
            $is_active = class_exists('GamiPress_BuddyPress');
            break;
        case 'gamipress-bbpress-integration':
            $is_active = class_exists('GamiPress_bbPress');
            break;
        case 'yipnyap-buddypress-extension':
            $is_active = function_exists('yipnyap_buddypress_extension_init');
            break;
        case 'vkreact':
            $is_active = function_exists('vkreact_activate');
            break;
        case 'vkreact-buddypress':
            $is_active = function_exists('vkreact_bp_activate');
            break;
        case 'vkmedia':
            $is_active = function_exists('vkmedia_activate');
            break;
        case 'yipnyap-widgets':
            $is_active = function_exists('vkwidgets_activate');
            break;
        case 'yipnyap-metaboxes':
            $is_active = function_exists('vkmetaboxes_activate');
            break;
        default:
            $is_active = false;
    }

    return $is_active;
}

/**
 * Checks if the GamiPress plugin is active.
 *
 * @return bool $is_active    True if the GamiPress plugin is active, false otherwise.
 */
function yipnyap_plugin_gamipress_is_active()
{
    $is_active = yipnyap_plugin_is_active('gamipress');

    return $is_active;
}

/**
 * Checks if the verified member for buddypress plugin is active.
 *
 * @return bool $is_active    True if the verified member for buddypress plugin is active, false otherwise.
 */
function yipnyap_plugin_bpverifiedmember_is_active()
{
    $is_active = yipnyap_plugin_is_active('bp-verified-member');

    return $is_active;
}

/**
 * Returns required plugins activation status
 *
 * @return $required_plugins_status       Required plugin with activation status.
 */
function yipnyap_plugin_get_required_plugins_activation_status()
{
    $required_plugins_status = [];

    $required_plugins = yipnyap_plugin_get_required_plugins();

    foreach ($required_plugins as $required_plugin) {
        $required_plugins_status[$required_plugin['plugin_name']] = yipnyap_plugin_is_active($required_plugin['plugin_name']);
    }

    $required_plugins_status['buddypress_groups'] = bp_is_active('groups');
    $required_plugins_status['buddypress_friends'] = bp_is_active('friends');
    $required_plugins_status['buddypress_messages'] = bp_is_active('messages');
    $required_plugins_status['buddypress_notifications'] = bp_is_active('notifications');

    $required_plugins_status['bp-verified-member'] = yipnyap_plugin_bpverifiedmember_is_active();

    return $required_plugins_status;
}
