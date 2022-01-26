<?php
/**
 * Yipnyap Customizer - Group Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_group($wp_customize) {
  /**
   * Group Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_group', [
    'title'       => esc_html_x('Page Headers - Groups', '(Customizer) Page Headers Group Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the group page header.', '(Customizer) Page Headers Group Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Group Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_group_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_group_control_image', [
    'label'       => esc_html_x('Group Page Header - Image', '(Customizer) Group Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the groups page header.', '(Customizer) Group Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_group',
    'settings'    => 'yipnyap_pageheader_group_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Group Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_group_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Groups', 'Groups Page - Title', 'yipnyap'),
  ]);

  $wp_customize->add_control('yipnyap_pageheader_group_control_title', [
    'label'       => esc_html_x('Group Page Header - Title', '(Customizer) Group Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the groups page header.', '(Customizer) Group Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_group',
    'settings'    => 'yipnyap_pageheader_group_setting_title'
  ]);

  /**
   * Group Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_group_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse all the groups of the community!', 'Groups Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_group_control_description', [
    'label'       => esc_html_x('Group Page Header - Description', '(Customizer) Group Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the groups page header.', '(Customizer) Group Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_group',
    'settings'    => 'yipnyap_pageheader_group_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_group');
