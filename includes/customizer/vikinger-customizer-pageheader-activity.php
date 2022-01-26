<?php
/**
 * Yipnyap Customizer - Activity Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_activity($wp_customize) {
  /**
   * Activity Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_activity', [
    'title'       => esc_html_x('Page Headers - Activity', '(Customizer) Page Headers Activity Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the activity page header.', '(Customizer) Page Headers Activity Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Activity Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_activity_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_activity_control_image', [
    'label'       => esc_html_x('Activity Page Header - Image', '(Customizer) Activity Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the activity page header.', '(Customizer) Activity Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_activity',
    'settings'    => 'yipnyap_pageheader_activity_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Activity Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_activity_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Newsfeed', 'Activity Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_activity_control_title', [
    'label'       => esc_html_x('Activity Page Header - Title', '(Customizer) Activity Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the activity page header.', '(Customizer) Activity Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_activity',
    'settings'    => 'yipnyap_pageheader_activity_setting_title'
  ]);

  /**
   * Activity Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_activity_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Check what your friends have been up to!', 'Activity Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_activity_control_description', [
    'label'       => esc_html_x('Activity Page Header - Description', '(Customizer) Activity Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the activity page header.', '(Customizer) Activity Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_activity',
    'settings'    => 'yipnyap_pageheader_activity_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_activity');
