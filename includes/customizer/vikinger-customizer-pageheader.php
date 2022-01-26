<?php
/**
 * Yipnyap Customizer - Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader($wp_customize) {
  /**
   * Page Header section
   */
  $wp_customize->add_section('yipnyap_pageheader', [
    'title'       => esc_html_x('Page Headers', '(Customizer) Page Headers Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the background image used in all the headers of the theme.', '(Customizer) Page Headers Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Page Header Display
   */
  $wp_customize->add_setting('yipnyap_pageheader_setting_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'display'
  ]);

  $wp_customize->add_control('yipnyap_pageheader_control_display', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Page Header Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide page headers.', '(Customizer) Page Header Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap'),
    ],
    'section'     => 'yipnyap_pageheader',
    'settings'    => 'yipnyap_pageheader_setting_display'
  ]);

  /**
   * Page Header Background Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_setting_background_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_control_background_image', [
    'label'       => esc_html_x('Page Header - Background Image', '(Customizer) Page Header Background Image - Title', 'yipnyap'),
    'description' => esc_html_x('Background image used for all the page headers.', '(Customizer) Page Header Background Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader',
    'settings'    => 'yipnyap_pageheader_setting_background_image',
    'mime_type'   => 'image'
  ]));
}

add_action('customize_register', 'yipnyap_customizer_pageheader');
