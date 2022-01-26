<?php
/**
 * Yipnyap Customizer - Loading Screen
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_loadingscreen($wp_customize) {
  /**
   * Loading Screen section
   */
  $wp_customize->add_section('yipnyap_loadingscreen', [
    'title'       => esc_html_x('Loading Screen', '(Customizer) Loading Screen - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can choose to display or hide the loading screen of the site. We recommend to display the loading screen to avoid FOUC (flash of unstyled content).', '(Customizer) Loading Screen - Description', 'yipnyap'),
    'priority'    => 270,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Loading Screen Display
   */
  $wp_customize->add_setting('yipnyap_loadingscreen_setting_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'display'
  ]);

  $wp_customize->add_control('yipnyap_loadingscreen_control_display', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Loading Screen Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the loading screen.', '(Customizer) Loading Screen Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap'),
    ],
    'section'     => 'yipnyap_loadingscreen',
    'settings'    => 'yipnyap_loadingscreen_setting_display',
  ]);

  /**
   * Loading Screen Logo
   */
  $wp_customize->add_setting('yipnyap_loadingscreen_setting_logo', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_loadingscreen_control_logo', [
    'label'     => esc_html_x('Logo', '(Customizer) Loading Screen - Logo - Title', 'yipnyap'),
    'description' => esc_html_x('You can upload an image to use for the loading screen logo. Site identity logo will be used by default.', '(Customizer) Loading Screen Option - Logo - Description', 'yipnyap'),
    'section'   => 'yipnyap_loadingscreen',
    'settings'  => 'yipnyap_loadingscreen_setting_logo',
    'mime_type' => 'image'
  ]));
}

add_action('customize_register', 'yipnyap_customizer_loadingscreen');
