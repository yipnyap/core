<?php
/**
 * Yipnyap Customizer - Side Menu
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_sidemenu($wp_customize) {
  /**
   * Side Menu section
   */
  $wp_customize->add_section('yipnyap_sidemenu', [
    'title'       => esc_html_x('Side Menu', '(Customizer) Side Menu Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can choose side menu options.', '(Customizer) Side Menu Options - Description', 'yipnyap'),
    'priority'    => 280,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Side Menu Display
   */
  $wp_customize->add_setting('yipnyap_sidemenu_setting_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'display'
  ]);

  $wp_customize->add_control('yipnyap_sidemenu_control_display', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Side Menu Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the side menu.', '(Customizer) Side Menu Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap'),
    ],
    'section'     => 'yipnyap_sidemenu',
    'settings'    => 'yipnyap_sidemenu_setting_display',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_sidemenu');
