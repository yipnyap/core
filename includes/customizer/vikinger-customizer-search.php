<?php
/**
 * Yipnyap Customizer - Search
 * 
 * @since 1.3.6
 */

function yipnyap_customizer_search($wp_customize) {
  /**
   * Search section
   */
  $wp_customize->add_section('yipnyap_search', [
    'title'       => esc_html_x('Search', '(Customizer) Search - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change search options.', '(Customizer) Search - Description', 'yipnyap'),
    'priority'    => 271,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Search Status
   */
  $wp_customize->add_setting('yipnyap_search_setting_status', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'display'
  ]);

  $wp_customize->add_control('yipnyap_search_control_status', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Search Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the search input on the header.', '(Customizer) Search Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap')
    ],
    'section'     => 'yipnyap_search',
    'settings'    => 'yipnyap_search_setting_status',
  ]);

  /**
   * Search Blog Enabled
   */
  $wp_customize->add_setting('yipnyap_search_setting_blog_enabled', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_bool',
    'default'           => true
  ]);

  $wp_customize->add_control('yipnyap_search_control_blog_enabled', [
    'label'       => esc_html_x('Show blog posts in search', '(Customizer) Search Option - Show blog posts in search - Title', 'yipnyap'),
    'description' => esc_html_x('If enabled, blog posts are displayed on search.', '(Customizer) Search Option - Show blog posts in search - Description', 'yipnyap'),
    'type'        => 'checkbox',
    'section'     => 'yipnyap_search',
    'settings'    => 'yipnyap_search_setting_blog_enabled',
  ]);

  /**
   * Search Members Enabled
   */
  $wp_customize->add_setting('yipnyap_search_setting_members_enabled', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_bool',
    'default'           => true
  ]);

  $wp_customize->add_control('yipnyap_search_control_members_enabled', [
    'label'       => esc_html_x('Show members in search', '(Customizer) Search Option - Show members in search - Title', 'yipnyap'),
    'description' => esc_html_x('If enabled, members are displayed on search.', '(Customizer) Search Option - Show members in search - Description', 'yipnyap'),
    'type'        => 'checkbox',
    'section'     => 'yipnyap_search',
    'settings'    => 'yipnyap_search_setting_members_enabled',
  ]);

  /**
   * Search Groups Enabled
   */
  $wp_customize->add_setting('yipnyap_search_setting_groups_enabled', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_bool',
    'default'           => true
  ]);

  $wp_customize->add_control('yipnyap_search_control_groups_enabled', [
    'label'       => esc_html_x('Show groups in search', '(Customizer) Search Option - Show groups in search - Title', 'yipnyap'),
    'description' => esc_html_x('If enabled, groups are displayed on search.', '(Customizer) Search Option - Show groups in search - Description', 'yipnyap'),
    'type'        => 'checkbox',
    'section'     => 'yipnyap_search',
    'settings'    => 'yipnyap_search_setting_groups_enabled',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_search');
