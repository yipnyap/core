<?php
/**
 * Yipnyap Template - Archive
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

  get_header();

  $year   = get_query_var('year');
  $month  = get_query_var('monthnum');
  $day    = get_query_var('day');

?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php
  /**
   * Post Filterable List
   */
  get_template_part('template-part/post/post-filterable-list', null, [
    'attributes'  => [
      'year'  => $year,
      'month' => $month,
      'day'   => $day
    ]
  ]);

?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
