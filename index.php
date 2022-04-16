<?php
/**
 * Yipnyap Template - Index
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  get_header();


// // hook into init late, so everything is registered
// // you can also use get_post_types where ever.  Any time after init is usually fine.
// $args = array(
//        'public'   => true,
//        '_builtin' => false,
//     );

//     $output = 'names'; // names or objects, note names is the default
//     $operator = 'and'; // 'and' or 'or'

//     $post_types = get_post_types( $args, $output, $operator ); 

//     foreach ( $post_types  as $post_type ) {

//        echo '<p>' . $post_type . '</p>';
//     }
?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php

  $page_header_status = get_theme_mod('yipnyap_pageheader_setting_display', 'hide');

  if ($page_header_status === 'display') {
    $blog_header_icon_id      = get_theme_mod('yipnyap_pageheader_blog_setting_image', false);
    $blog_header_title        = get_theme_mod('yipnyap_pageheader_blog_setting_title', esc_html_x('Blog Posts', 'Blog Page - Title', 'yipnyap'));
    $blog_header_description  = get_theme_mod('yipnyap_pageheader_blog_setting_description', esc_html_x('Read about news, announcements and more!', 'Blog Page - Description', 'yipnyap'));

    if ($blog_header_icon_id) {
      $blog_header_icon_url = wp_get_attachment_image_src($blog_header_icon_id , 'full')[0];
    } else {
      $blog_header_icon_url = yipnyap_customizer_blog_page_image_get_default();
    }

    /**
     * Section Banner
     */
    get_template_part('template-part/section/section', 'banner', [
      'section_icon_url'    => $blog_header_icon_url,
      'section_title'       => $blog_header_title,
      'section_description' => $blog_header_description
    ]);
  }

  $sticky_posts = yipnyap_post_get_sticky_posts();

  if (count($sticky_posts) > 0) {
    foreach ($sticky_posts as $sticky_post) {
      /**
       * Post Sticky
       */
      get_template_part('template-part/post/post', 'sticky', [
        'post' => $sticky_post
      ]);
    }
  }

  /**
   * Post Filterable List
   */
  get_template_part('template-part/post/post-filterable-list', null, [
    'allow_post_types'  => true,
    'post_types'        => yipnyap_blog_post_types_to_display_in_blog_get()
  ]);

?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
