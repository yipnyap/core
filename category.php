<?php
/**
 * Yipnyap Template - Category
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

  get_header();

  $category = get_queried_object();

?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php
  /**
   * Section Header
   */
  get_template_part('template-part/section/section', 'header', [
    'section_pretitle'  => esc_html__('Search Results', 'yipnyap'),
    'section_title'     => esc_html__('Category', 'yipnyap') . ':',
    'section_text'      => $category->cat_name
  ]);

  /**
   * Post Filterable List
   */
  get_template_part('template-part/post/post-filterable-list', null, [
    'attributes'  => [
      'category'  => $category->cat_ID
    ]
  ]);

?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
