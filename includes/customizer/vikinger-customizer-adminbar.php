<?php
/**
 * Yipnyap Customizer - Admin Bar
 *
 * @since 1.0.0
 */

function yipnyap_customizer_adminbar($wp_customize) {
  /**
   * Admin Bar section
   */
  $wp_customize->add_section('yipnyap_adminbar', [
    'title'       => esc_html_x('Admin Bar', '(Customizer) Admin Bar Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can choose admin bar options.', '(Customizer) Admin Bar Options - Description', 'yipnyap'),
    'priority'    => 25,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Admin Bar Display
   */
  $wp_customize->add_setting('yipnyap_adminbar_setting_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'hide'
  ]);

  $wp_customize->add_control('yipnyap_adminbar_control_display', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Admin Bar Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the admin bar. Selecting "Hide" will hide the admin bar on the frontend for all logged in users except administrators. This doesn\'t affect BuddyPress toolbar for logged out users, to hide the bar for logged out users, deactivate BuddyPress Toolbar setting in the  Settings -> BuddyPress -> Options tab.', '(Customizer) Admin Bar Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap'),
    ],
    'section'     => 'yipnyap_adminbar',
    'settings'    => 'yipnyap_adminbar_setting_display',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_adminbar');
