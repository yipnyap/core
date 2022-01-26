<?php
/**
 * Yipnyap Template - BuddyPress Group Header
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  $group = get_query_var('group');

  $nav_items = yipnyap_groups_get_navigation_items($group);
  
?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php

  /**
   * Profile Header V2
   */
  get_template_part('template-part/profile/profile-header', 'v2', [
    'group' => $group
  ]);

  // if the group is visible to the current logged in user (for example a private group and the user is a member)
  if (bp_group_is_visible()) {
    /**
     * Section Navigation
     */
    get_template_part('template-part/section/section', 'navigation', [
      'nav_items'       => $nav_items,
      'nav_items_color' => 'secondary'
    ]);
  } else {
  // the group isn't visible to the current logged in user
    /**
     * Message Information
     */
    get_template_part('template-part/alert/alert', 'box', [
      'type'  => 'info',
      'title' => esc_html__('Private Group', 'yipnyap'),
      'text'  => esc_html__('You need to be a member of this group to be able to see its content. If you are interested in joining this group, please send a membership request and wait for approval!.', 'yipnyap')
    ]);
  }

?>
