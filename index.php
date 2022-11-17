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
