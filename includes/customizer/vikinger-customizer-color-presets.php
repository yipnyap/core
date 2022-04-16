<?php
/**
 * Yipnyap Customizer - Color Presets
 *
 * @since 1.0.0
 */

function yipnyap_customizer_color_presets($wp_customize)
{
    /**
     * Color Presets section
     */
    $wp_customize->add_section('yipnyap_color_presets', [
        'title' => esc_html_x('Color Presets', '(Customizer) Color Presets Options - Title', 'yipnyap'),
        'description' => sprintf(esc_html_x('From here, you can choose the default color preset of the site, enable the color theme switch, select which color preset to assign to your site light and dark color themes and select the default color theme the site uses.%sYou can customize individual preset colors from the Customizer -> Yipnyap Settings -> Colors - Preset menu.', '(Customizer) Color Presets Options - Description', 'yipnyap'), '<br><br>', '<br><br>'),
        'priority' => 99,
        'panel' => 'yipnyap_customizer'
    ]);

    /**
     * Color Preset
     */
    $wp_customize->add_setting('yipnyap_color_presets_setting_name', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'light'
    ]);

    $wp_customize->add_control('yipnyap_color_presets_control_name', [
        'label' => esc_html_x('Color Preset', '(Customizer) Color Preset - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose which color preset you want to use by default (when the Color Theme Switch is disabled).', '(Customizer) Color Preset - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'custom' => esc_html__('Custom', 'yipnyap'),
            'light' => esc_html__('Light', 'yipnyap'),
            'dark' => esc_html__('Dark', 'yipnyap'),
            'darkblue' => esc_html__('Dark Blue', 'yipnyap'),
            'darkpurple' => esc_html__('Dark Purple', 'yipnyap'),
            'darkcyan' => esc_html__('Dark Cyan', 'yipnyap'),
            'carbonyellow' => esc_html__('Carbon Yellow', 'yipnyap')
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_name',
    ]);

    /**
     * Color Theme Switch - Status
     */
    $wp_customize->add_setting('yipnyap_color_presets_setting_theme_switch_status', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'disabled'
    ]);

    $wp_customize->add_control('yipnyap_color_presets_control_theme_switch_status', [
        'label' => esc_html_x('Color Theme Switch - Status', '(Customizer) Color Theme Switch Status - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose to enable or disable the color theme switch. When enabled, your site users can toggle the color theme with the sun / moon button that is on the header on desktop and on the top left menu on mobile.', '(Customizer) Color Theme Switch Status - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'enabled' => esc_html__('Enabled', 'yipnyap'),
            'disabled' => esc_html__('Disabled', 'yipnyap')
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_theme_switch_status',
    ]);

    /**
     * Color Theme Switch - Light
     */
    $wp_customize->add_setting('yipnyap_color_presets_setting_theme_switch_light', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'light'
    ]);

    $wp_customize->add_control('yipnyap_color_presets_control_theme_switch_light', [
        'label' => esc_html_x('Color Theme Switch - Light', '(Customizer) Color Theme Switch Light - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose which color preset you want to use for your site light theme.', '(Customizer) Color Theme Switch Light - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'custom' => esc_html__('Custom', 'yipnyap'),
            'light' => esc_html__('Light', 'yipnyap'),
            'dark' => esc_html__('Dark', 'yipnyap'),
            'darkblue' => esc_html__('Dark Blue', 'yipnyap'),
            'darkpurple' => esc_html__('Dark Purple', 'yipnyap'),
            'darkcyan' => esc_html__('Dark Cyan', 'yipnyap'),
            'carbonyellow' => esc_html__('Carbon Yellow', 'yipnyap')
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_theme_switch_light'
    ]);

    /**
     * Color Theme Switch - Dark
     */
    $wp_customize->add_setting('yipnyap_color_presets_setting_theme_switch_dark', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'dark'
    ]);

    $wp_customize->add_control('yipnyap_color_presets_control_theme_switch_dark', [
        'label' => esc_html_x('Color Theme Switch - Dark', '(Customizer) Color Theme Switch Dark - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose which color preset you want to use for your site dark theme.', '(Customizer) Color Theme Switch Dark - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'custom' => esc_html__('Custom', 'yipnyap'),
            'light' => esc_html__('Light', 'yipnyap'),
            'dark' => esc_html__('Dark', 'yipnyap'),
            'darkblue' => esc_html__('Dark Blue', 'yipnyap'),
            'darkpurple' => esc_html__('Dark Purple', 'yipnyap'),
            'darkcyan' => esc_html__('Dark Cyan', 'yipnyap'),
            'carbonyellow' => esc_html__('Carbon Yellow', 'yipnyap')
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_theme_switch_dark'
    ]);

    /**
     * Color Theme Switch - Default
     */
    $wp_customize->add_setting('yipnyap_color_presets_setting_theme_switch_default', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'light'
    ]);

    $wp_customize->add_control('yipnyap_color_presets_control_theme_switch_default', [
        'label' => esc_html_x('Color Theme Switch - Default', '(Customizer) Color Theme Switch Default - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose the default active color theme for all the users of your site.', '(Customizer) Color Theme Switch Default - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'light' => esc_html__('Light', 'yipnyap'),
            'dark' => esc_html__('Dark', 'yipnyap')
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_theme_switch_default',
    ]);
}

add_action('customize_register', 'yipnyap_customizer_color_presets');
