<?php
/**
 * Yipnyap Customizer - Rank Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_rank($wp_customize) {
  /**
   * Rank Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_rank', [
    'title'       => esc_html_x('Page Headers - Ranks', '(Customizer) Page Headers Rank Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the ranks page header.', '(Customizer) Page Headers Rank Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Rank Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_rank_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_rank_control_image', [
    'label'       => esc_html_x('Rank Page Header - Image', '(Customizer) Rank Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the ranks page header.', '(Customizer) Rank Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_rank',
    'settings'    => 'yipnyap_pageheader_rank_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Rank Header Title
   */
  $wp_customize->add_setting('yipnyap_pageheader_rank_setting_title', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Ranks', 'Ranks Page - Title', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_rank_control_title', [
    'label'       => esc_html_x('Rank Page Header - Title', '(Customizer) Rank Page Header Title - Title', 'yipnyap'),
    'description' => esc_html_x('Title of the ranks page header.', '(Customizer) Rank Page Header Title - Description', 'yipnyap'),
    'type'        => 'text',
    'section'     => 'yipnyap_pageheader_rank',
    'settings'    => 'yipnyap_pageheader_rank_setting_title'
  ]);

  /**
   * Rank Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_rank_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse all the ranks of the community!', 'Ranks Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_rank_control_description', [
    'label'       => esc_html_x('Rank Page Header - Description', '(Customizer) Rank Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the ranks page header.', '(Customizer) Rank Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_rank',
    'settings'    => 'yipnyap_pageheader_rank_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_rank');
