<?php
/**
 * Yipnyap Customizer - Groups
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_groups($wp_customize) {
  /**
   * Groups section
   */
  $wp_customize->add_section('yipnyap_groups', [
    'title'       => esc_html_x('Groups', '(Customizer) Groups Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the groups options.', '(Customizer) Groups Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Groups Default Avatar
   */
  $wp_customize->add_setting('yipnyap_groups_setting_default_avatar', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_groups_control_default_avatar', [
    'label'       => esc_html_x('Groups Default Avatar', '(Customizer) Groups Default Avatar - Title', 'yipnyap'),
    'description' => esc_html_x('Default avatar assigned to groups.', '(Customizer) Groups Default Avatar - Description', 'yipnyap'),
    'section'     => 'yipnyap_groups',
    'settings'    => 'yipnyap_groups_setting_default_avatar',
    'mime_type'   => 'image'
  ]));

  /**
   * Groups Default Cover
   */
  $wp_customize->add_setting('yipnyap_groups_setting_default_cover', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_groups_control_default_cover', [
    'label'       => esc_html_x('Groups Default Cover', '(Customizer) Groups Default Cover - Title', 'yipnyap'),
    'description' => esc_html_x('Default cover assigned to groups.', '(Customizer) Groups Default Cover - Description', 'yipnyap'),
    'section'     => 'yipnyap_groups',
    'settings'    => 'yipnyap_groups_setting_default_cover',
    'mime_type'   => 'image'
  ]));
}

add_action('customize_register', 'yipnyap_customizer_groups');
