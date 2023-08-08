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
            'light' => esc_html__('Light', 'yipnyap'),
            'dark' => esc_html__('Dark', 'yipnyap'),
        ],
        'section' => 'yipnyap_color_presets',
        'settings' => 'yipnyap_color_presets_setting_name',
    ]);
}

add_action('customize_register', 'yipnyap_customizer_color_presets');
