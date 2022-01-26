<?php
/**
 * Yipnyap Customizer - Settings Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_settings($wp_customize) {
  /**
   * Settings Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_settings', [
    'title'       => esc_html_x('Page Headers - Settings', '(Customizer) Page Headers Settings Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the settings page header.', '(Customizer) Page Headers Settings Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Settings Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_settings_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_settings_control_image', [
    'label'       => esc_html_x('Settings Page Header - Image', '(Customizer) Settings Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the settings page header.', '(Customizer) Settings Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_settings',
    'settings'    => 'yipnyap_pageheader_settings_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Settings Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_settings_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Account Hub', 'Settings Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_settings_control_title', [
    'label'       => esc_html_x('Settings Page Header - Title', '(Customizer) Settings Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the settings page header.', '(Customizer) Settings Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_settings',
    'settings'    => 'yipnyap_pageheader_settings_setting_title'
  ]);

  /**
   * Settings Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_settings_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Profile info, notifications, friends, groups, messages and much more!', 'Settings Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_settings_control_description', [
    'label'       => esc_html_x('Settings Page Header - Description', '(Customizer) Settings Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the settings page header.', '(Customizer) Settings Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_settings',
    'settings'    => 'yipnyap_pageheader_settings_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_settings');
