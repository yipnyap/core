<?php
/**
 * Yipnyap Customizer - Search Page Header
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_search($wp_customize) {
  /**
   * Search Header section
   */
  $wp_customize->add_section('yipnyap_pageheader_search', [
    'title'       => esc_html_x('Page Headers - Search', '(Customizer) Page Headers Search Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can customize the search page header.', '(Customizer) Page Headers Search Options - Description', 'yipnyap'),
    'priority'    => 290,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Search Header Image
   */
  $wp_customize->add_setting('yipnyap_pageheader_search_setting_image', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_pageheader_search_control_image', [
    'label'       => esc_html_x('Search Page Header - Image', '(Customizer) Search Page Header Image - Title', 'yipnyap'),
    'description' => esc_html_x('Image of the search page header.', '(Customizer) Search Page Header Image - Description', 'yipnyap'),
    'section'     => 'yipnyap_pageheader_search',
    'settings'    => 'yipnyap_pageheader_search_setting_image',
    'mime_type'   => 'image'
  ]));

  /**
   * Search Header Description
   */
  $wp_customize->add_setting('yipnyap_pageheader_search_setting_description', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => esc_html_x('Browse your search results', 'Search Page - Description', 'yipnyap')
  ]);

  $wp_customize->add_control('yipnyap_pageheader_search_control_description', [
    'label'       => esc_html_x('Search Page Header - Description', '(Customizer) Search Page Header Description - Title', 'yipnyap'),
    'description' => esc_html_x('Description of the search page header.', '(Customizer) Search Page Header Description - Description', 'yipnyap'),
    'type'        => 'textarea',
    'section'     => 'yipnyap_pageheader_search',
    'settings'    => 'yipnyap_pageheader_search_setting_description'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_search');
