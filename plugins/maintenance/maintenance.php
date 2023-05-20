<?php
/**
 * Under Maintenance
 */
add_action('admin_init', function () {
    add_settings_section(
        'yipnyap_settings_section', // Section ID
        'ADDITIONAL SETTINGS', // Section Title
        'yipnyap_section_options_callback', // Content Callback
        'general' // Show under "General" settings page
    );
    add_settings_field(
        'maintenance_mode', // Option ID
        'Maintenance mode', // Option Label
        'maintenance_mode_callback', // Callback for Arguments
        'general', // Show under "General" settings page
        'yipnyap_settings_section', // Name of the section
        [ // The $args to pass to the callback
            'maintenance_mode' // Should match Option ID
        ]
    );
    register_setting('general', 'maintenance_mode', 'esc_attr');
});

function yipnyap_section_options_callback(): void {
    echo '<p>Additional settings for Yipnyap</p>';
}

function maintenance_mode_callback($args): void {
    // Checkbox Callback
    $value = get_option($args[0]);
    $checked = ($value == 'on') ? 'checked' : '';
    echo "<label>
      <input type=\"checkbox\" id=\"$args[0]\" name=\"$args[0]\" $checked />
      <span>Check to activate Maintenance Mode page</span>
    </label><p>A general <i>Under Maintenance</i> page will be shown to non-admin users.</p>";
}

add_action('init', function () {
    $isLoginPage = basename($_SERVER['PHP_SELF']) == 'wp-login.php';
    $isMaintenanceModeOn = get_option('maintenance_mode') == 'on';

    if (
        $isMaintenanceModeOn &&
        !$isLoginPage &&
        !is_user_logged_in() &&
        !is_admin() &&
        !current_user_can('update_plugins')
    ) {
        get_template_part('plugins/maintenance/page');
        exit();
    }
}, 30);