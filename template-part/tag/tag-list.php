<?php
/**
 * Yipnyap Template Part - Tag List
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @see get_the_tags
 * 
 * @param array $args {
 *   @type array $tags    Tag items.
 * }
 */

?>

<!-- TAG LIST -->
<div class="tag-list">
<?php
  foreach ($args['tags'] as $tag):
    $tag_link = get_tag_link($tag->term_id);
?>
  <!-- TAG ITEM -->
  <a class="tag-item secondary" href="<?php echo esc_url($tag_link); ?>"><?php echo esc_html($tag->name); ?></a>
  <!-- /TAG ITEM -->
<?php
  endforeach;
?>
</div>
<!-- /TAG LIST -->