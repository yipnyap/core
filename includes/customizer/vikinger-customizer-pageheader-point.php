<?php
/**
 * Yipnyap Customizer - Point Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_point($wp_customize) {
  /**
   * Point Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_point', [
    'title'       => esc_html_x('Page Headers - Points', '(Customizer) Page Headers Point Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the points page header.', '(Customizer) Page Headers Point Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Point Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_point_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_point_control_image', [
    'label'       => esc_html_x('Point Page Header - Image', '(Customizer) Point Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the points page header.', '(Customizer) Point Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_point',
    'settings'    => 'yipnyap_pageheader_point_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Point Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_point_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Credits', 'Credits Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_point_control_title', [
    'label'       => esc_html_x('Point Page Header - Title', '(Customizer) Point Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the points page header.', '(Customizer) Point Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_point',
    'settings'    => 'yipnyap_pageheader_point_setting_title'
  ]);

  /**
   * Point Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_point_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse all the credits of the community!', 'Credits Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_point_control_description', [
    'label'       => esc_html_x('Point Page Header - Description', '(Customizer) Point Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the points page header.', '(Customizer) Point Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_point',
    'settings'    => 'yipnyap_pageheader_point_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_point');
