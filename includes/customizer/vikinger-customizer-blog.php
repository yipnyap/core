<?php
/**
 * Yipnyap Customizer - Blog
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_blog($wp_customize) {
  /**
   * Blog section
   */
  $wp_customize->add_section('yipnyap_blog', [
    'title'       => esc_html_x('Blog', '(Customizer) Blog - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the blog post type used for regular open posts.', '(Customizer) Blog - Description', 'yipnyap'),
    'priority'    => 280,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Blog Type
   */
  $wp_customize->add_setting('yipnyap_blog_setting_type', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'v1'
  ]);

  $wp_customize->add_control('yipnyap_blog_control_type', [
    'label'       => esc_html_x('Version 1 / Version 2', '(Customizer) Blog Option - Version 1 / Version 2 - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to use version 1 or version 2 of the blog open post.', '(Customizer) Blog Option - Version 1 / Version 2 - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'v1'  => esc_html__('Version 1', 'yipnyap'),
      'v2'  => esc_html__('Version 2', 'yipnyap')
    ],
    'section'     => 'yipnyap_blog',
    'settings'    => 'yipnyap_blog_setting_type',
  ]);

  /**
   * Post Type to Display in Blog
   */
  $wp_customize->add_setting('yipnyap_blog_setting_post_types_to_display_in_blog', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text_comma_separated',
    'default'           => yipnyap_blog_post_types_default_get()
  ]);

  $wp_customize->add_control('yipnyap_blog_control_post_types_to_display_in_blog', [
    'label'       => esc_html_x('Post Types - Display in Blog', '(Customizer) Post Types Option - Display in Blog - Title', 'yipnyap'),
    'description' => sprintf(
      esc_html_x('You can enter the post types allowed for display in the site blog. Enter each post type you want to display separated by a comma (,)%s%sFor example, to display WooCommerce products along with regular posts, enter "post,product" or "product" to only display products.%s', '(Customizer) Post Types Option - Display in Blog - Description', 'yipnyap'),
      '<br><br>',
      '<strong>',
      '</strong>'
    ),
    'type'        => 'text',
    'section'     => 'yipnyap_blog',
    'settings'    => 'yipnyap_blog_setting_post_types_to_display_in_blog',
  ]);

  /**
   * Post Type to Display in Search
   */
  $wp_customize->add_setting('yipnyap_blog_setting_post_types_to_display_in_search', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text_comma_separated',
    'default'           => yipnyap_blog_post_types_default_get()
  ]);

  $wp_customize->add_control('yipnyap_blog_control_post_types_to_display_in_search', [
    'label'       => esc_html_x('Post Types - Display in Search', '(Customizer) Post Types Option - Display in Search - Title', 'yipnyap'),
    'description' => sprintf(
      esc_html_x('You can enter the post types allowed for display in the site search. Enter each post type you want to display separated by a comma (,)%s%sFor example, to display WooCommerce products along with regular posts, enter "post,product" or "product" to only display products.%s', '(Customizer) Post Types Option - Display in Search - Description', 'yipnyap'),
      '<br><br>',
      '<strong>',
      '</strong>'
    ),
    'type'        => 'text',
    'section'     => 'yipnyap_blog',
    'settings'    => 'yipnyap_blog_setting_post_types_to_display_in_search',
  ]);

  /**
   * Blog Post Type Split Display
   */
  $wp_customize->add_setting('yipnyap_blog_setting_post_type_split_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'disabled'
  ]);

  $wp_customize->add_control('yipnyap_blog_control_post_type_split_display', [
    'label'       => esc_html_x('Post Types - Split Display', '(Customizer) Post Type Option - Split Display - Title', 'yipnyap'),
    'description' => esc_html_x('If enabled, one post list will be displayed for each post type.', '(Customizer) Post Type Filter Option - Display - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'enabled'   => esc_html__('Enabled', 'yipnyap'),
      'disabled'  => esc_html__('Disabled', 'yipnyap')
    ],
    'section'     => 'yipnyap_blog',
    'settings'    => 'yipnyap_blog_setting_post_type_split_display',
  ]);

  /**
   * Blog Post Type Filter Display
   */
  $wp_customize->add_setting('yipnyap_blog_setting_post_type_filter_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'disabled'
  ]);

  $wp_customize->add_control('yipnyap_blog_control_post_type_filter_display', [
    'label'       => esc_html_x('Post Types - Filter Display', '(Customizer) Post Type Option - Filter Display - Title', 'yipnyap'),
    'description' => esc_html_x('If enabled, users will be able to filter posts lists by post type when "Post Type - Split Display" is disabled.', '(Customizer) Post Type Option - Filter Display - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'enabled'   => esc_html__('Enabled', 'yipnyap'),
      'disabled'  => esc_html__('Disabled', 'yipnyap')
    ],
    'section'     => 'yipnyap_blog',
    'settings'    => 'yipnyap_blog_setting_post_type_filter_display',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_blog');
