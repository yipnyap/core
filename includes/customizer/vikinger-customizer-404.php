<?php
/**
 * Yipnyap Customizer - 404
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_404($wp_customize) {
  /**
   * 404 section
   */
  $wp_customize->add_section('yipnyap_404', [
    'title'       => esc_html_x('404 Page', '(Customizer) 404 Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the image and text used in the 404 error page.', '(Customizer) 404 Options - Description', 'yipnyap'),
    'priority'    => 310,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * 404 Image
   */
  $wp_customize->add_setting('yipnyap_404_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_404_control_image', [
    'label'     => esc_html_x('404 - Image', '(Customizer) 404 Option - Image - Title', 'yipnyap'),
    'section'   => 'yipnyap_404',
    'settings'  => 'yipnyap_404_setting_image',
    'mime_type' => 'image'
  ]));

  /**
   * 404 Title
   */
  $wp_customize->add_setting('yipnyap_404_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html__('OOPS!!...Wrong Turn!!', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_404_control_title', [
    'label'     => esc_html_x('404 - Title', '(Customizer) 404 Option - Title - Title', 'yipnyap'),
    'type'      => 'text',
    'section'   => 'yipnyap_404',
    'settings'  => 'yipnyap_404_setting_title'
  ]);

  /**
   * 404 Description
   */
  $wp_customize->add_setting('yipnyap_404_setting_description', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text',
    'default'           => sprintf(esc_html__('Seems that you encountered a web black hole that absorbed the page you were looking for! But don\'t panic because you can go back!%sIf the problem persists, please send us an email to our support team at %ssupport@yipnyap.com%s', 'yipnyap'), '<br><br>', '<a href="mailto:support@yipnyap.com">', '</a>')
  ]);

  $wp_customize->add_control('yipnyap_404_control_description', [
    'label'     => esc_html_x('404 - Description', '(Customizer) 404 Option - Description - Title', 'yipnyap'),
    'type'      => 'textarea',
    'section'   => 'yipnyap_404',
    'settings'  => 'yipnyap_404_setting_description'
  ]);

  /**
   * 404 Button Text
   */
  $wp_customize->add_setting('yipnyap_404_setting_button_text', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html__('Go Back', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_404_control_button_text', [
    'label'     => esc_html_x('404 - Button Text', '(Customizer) 404 Option - Button Text - Title', 'yipnyap'),
    'type'      => 'text',
    'section'   => 'yipnyap_404',
    'settings'  => 'yipnyap_404_setting_button_text'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_404');
