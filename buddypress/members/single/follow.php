<?php
/**
 * YapSDK Follow List
 * 
 * Displays member follows
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  $member = get_query_var('member');

  /**
   * Section Header
   */
  $count = bp_follow_total_follow_counts(array(
    // change 5 to whatever user ID you need to fetch
    'user_id' => $member['id']
  ));

  get_template_part('template-part/section/section', 'header', [
    'section_pretitle'  => sprintf(
      esc_html_x('Browse %s', 'Section Header - Pretitle', 'vikinger'),
      $member['name']
    ),
    'section_title'     => esc_html__('Follow', 'vikinger'),
    'section_text'      => $count['followers']
  ]);

  $members_grid_type = vikinger_logged_user_grid_type_get('member');

?>

<?php do_action( 'bp_before_member_' . bp_current_action() . '_content' ); ?>

<?php // this is important! do not remove the classes in this DIV as AJAX relies on it! ?>
<div id="members-dir-list" class="dir-list members follow <?php echo bp_current_action(); ?>" data-bp-list="members">
	<?php if ( function_exists( 'bp_nouveau' ) ) : ?>
		<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'generic-loading' ); ?></div>	
	<?php else : ?>
		<?php bp_get_template_part( 'members/members-loop' ) ?>
	<?php endif; ?>
</div>

<?php do_action( 'bp_after_member_' . bp_current_action() . '_content' ); ?>
