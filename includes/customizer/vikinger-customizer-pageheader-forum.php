<?php
/**
 * Yipnyap Customizer - Forum Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_forum($wp_customize) {
  /**
   * Forum Page Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_forum', [
    'title'       => esc_html_x('Page Headers - Forum', '(Customizer) Page Headers Forum Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the forum page header.', '(Customizer) Page Headers Forum Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Forum Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_forum_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_forum_control_image', [
    'label'       => esc_html_x('Forum Page Header - Image', '(Customizer) Forum Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the forum page header.', '(Customizer) Forum Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_forum',
    'settings'    => 'yipnyap_pageheader_forum_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Forum Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_forum_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Forums', 'Forum Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_forum_control_title', [
    'label'       => esc_html_x('Forum Page Header - Title', '(Customizer) Forum Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the forum page header.', '(Customizer) Forum Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_forum',
    'settings'    => 'yipnyap_pageheader_forum_setting_title'
  ]);

  /**
   * Forum Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_forum_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Talk about anything you want!', 'Forum Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_forum_control_description', [
    'label'       => esc_html_x('Forum Page Header - Description', '(Customizer) Forum Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the forum page header.', '(Customizer) Forum Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_forum',
    'settings'    => 'yipnyap_pageheader_forum_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_forum');
