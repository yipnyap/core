<?php
/**
 * Yipnyap Customizer - Badge Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_badge($wp_customize) {
  /**
   * Badge Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_badge', [
    'title'       => esc_html_x('Page Headers - Badges', '(Customizer) Page Headers Badge Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the badges page header.', '(Customizer) Page Headers Badge Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Badge Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_badge_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_badge_control_image', [
    'label'       => esc_html_x('Badge Page Header - Image', '(Customizer) Badge Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the badges page header.', '(Customizer) Badge Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_badge',
    'settings'    => 'yipnyap_pageheader_badge_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Badge Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_badge_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Badges', 'Badges Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_badge_control_title', [
    'label'       => esc_html_x('Badge Page Header - Title', '(Customizer) Badge Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the badges page header.', '(Customizer) Badge Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_badge',
    'settings'    => 'yipnyap_pageheader_badge_setting_title'
  ]);

  /**
   * Badge Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_badge_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse all the badges of the community!', 'Badges Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_badge_control_description', [
    'label'       => esc_html_x('Badge Page Header - Description', '(Customizer) Badge Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the badges page header.', '(Customizer) Badge Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_badge',
    'settings'    => 'yipnyap_pageheader_badge_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_badge');
