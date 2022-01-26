<?php
/**
 * Yipnyap Customizer - Quest Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_quest($wp_customize) {
  /**
   * Quest Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_quest', [
    'title'       => esc_html_x('Page Headers - Quests', '(Customizer) Page Headers Quest Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the quests page header.', '(Customizer) Page Headers Quest Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Quest Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_quest_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_quest_control_image', [
    'label'       => esc_html_x('Quest Page Header - Image', '(Customizer) Quest Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the quests page header.', '(Customizer) Quest Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_quest',
    'settings'    => 'yipnyap_pageheader_quest_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Quest Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_quest_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Quests', 'Quests Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_quest_control_title', [
    'label'       => esc_html_x('Quest Page Header - Title', '(Customizer) Quest Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the quests page header.', '(Customizer) Quest Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_quest',
    'settings'    => 'yipnyap_pageheader_quest_setting_title'
  ]);

  /**
   * Quest Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_quest_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse all the quests of the community!', 'Quests Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_quest_control_description', [
    'label'       => esc_html_x('Quest Page Header - Description', '(Customizer) Quest Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the quests page header.', '(Customizer) Quest Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_quest',
    'settings'    => 'yipnyap_pageheader_quest_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_quest');
