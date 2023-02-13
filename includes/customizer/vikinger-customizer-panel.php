<?php
/**
 * Yipnyap Customizer - Panel
 *
 * @since 1.0.0
 */

/**
 * Creates the yipnyap customizer main panel
 */
function yipnyap_customizer_panel($wp_customize)
{
    $wp_customize->add_panel('yipnyap_customizer', [
        'title' => esc_html_x('Yipnyap Settings', '(Customizer) Settings - Title', 'yipnyap'),
        'description' => esc_html_x('From here, you can customize your theme settings.', '(Customizer) Settings - Description', 'yipnyap'),
        'priority' => 300
    ]);
}

add_action('customize_register', 'yipnyap_customizer_panel');
