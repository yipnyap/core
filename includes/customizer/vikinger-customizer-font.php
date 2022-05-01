<?php
/**
 * Yipnyap Customizer - Font
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_font($wp_customize) {
  /**
   * Font section
   */
  $wp_customize->add_section('yipnyap_font', [
    'title'       => esc_html_x('Font', '(Customizer) Font - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can select the primary and secondary fonts used in the theme.', '(Customizer) Font - Description', 'yipnyap'),
    'priority'    => 50,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Fonts API KEY
   */
  $wp_customize->add_setting('yipnyap_font_setting_api_key', [
    'sanitize_callback' => 'sanitize_text_field'
  ]);

  $wp_customize->add_control('yipnyap_font_control_api_key', [
    'label'     => esc_html_x('Google Fonts - API KEY', '(Customizer) Font Option - Google Fonts API KEY - Title', 'yipnyap'),
    'type'      => 'text',
    'section'   => 'yipnyap_font',
    'settings'  => 'yipnyap_font_setting_api_key'
  ]);

  /**
   * Primary Font
   */
  $wp_customize->add_setting('yipnyap_font_setting_primary', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'Inter'
  ]);

  $wp_customize->add_control('yipnyap_font_control_primary', [
    'label'       => esc_html_x('Primary', '(Customizer) Font Option - Primary - Title', 'yipnyap'),
    'description' => esc_html_x('The primary font used in the theme.', '(Customizer) Font Option - Primary - Description', 'yipnyap'),
    'type'        => 'select',
    'choices'     => yipnyap_customizer_theme_font_options_get(),
    'section'     => 'yipnyap_font',
    'settings'    => 'yipnyap_font_setting_primary',
  ]);

  /**
   * Secondary Font
   */
  $wp_customize->add_setting('yipnyap_font_setting_secondary', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'Poppins'
  ]);

  $wp_customize->add_control('yipnyap_font_control_secondary', [
    'label'       => esc_html_x('Secondary', '(Customizer) Font Option - Secondary - Title', 'yipnyap'),
    'description' => esc_html_x('The secondary font used in the theme (used for the site name in the header, footer and loading screen).', '(Customizer) Font Option - Secondary - Description', 'yipnyap'),
    'type'        => 'select',
    'choices'     => yipnyap_customizer_theme_font_options_get(),
    'section'     => 'yipnyap_font',
    'settings'    => 'yipnyap_font_setting_secondary',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_font');
