<?php
/**
 * Yipnyap Customizer - Avatar
 * 
 * @since 1.3.6
 */

function yipnyap_customizer_avatar($wp_customize) {
  /**
   * Avatar section
   */
  $wp_customize->add_section('yipnyap_avatar', [
    'title'       => esc_html_x('Avatar', '(Customizer) Avatar - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change avatar settings.', '(Customizer) Avatar - Description', 'yipnyap'),
    'priority'    => 275,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Avatar Type
   */
  $wp_customize->add_setting('yipnyap_avatar_setting_type', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'circle'
  ]);

  $wp_customize->add_control('yipnyap_avatar_control_type', [
    'label'       => esc_html_x('Avatar Type', '(Customizer) Avatar Option - Type - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to use hexagon, circle or square avatars for members and groups.', '(Customizer) Avatar Option - Type - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'hexagon' => esc_html__('Hexagon', 'yipnyap'),
      'circle'  => esc_html__('Circle', 'yipnyap'),
      'square'  => esc_html__('Square', 'yipnyap')
    ],
    'section'     => 'yipnyap_avatar',
    'settings'    => 'yipnyap_avatar_setting_type',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_avatar');
