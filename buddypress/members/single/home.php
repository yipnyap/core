<?php
/**
 * Yipnyap Template - BuddyPress Members Home
 *
 * Determines member template to display
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

  /**
   * Redirect admin when trying to access other users settings
   */
  if (bp_is_user_settings() && !bp_is_my_profile() || bp_is_user_messages()) {
    $user_domain = bp_displayed_user_domain();

    wp_safe_redirect(trailingslashit($user_domain . 'activity'));
    exit;
  }

  $displayed_user   = bp_get_displayed_user();
  // xprofile and groups necessary
  $displayed_member = yipnyap_members_get(['include' => [$displayed_user->id], 'data_scope' => 'user-preview']);

  // if user isn't activated (user_status = 2) or marked as spam (user_status = 1)
  // redirect to home
  if (count($displayed_member) === 0) {
    wp_safe_redirect(home_url('/'));
    exit;
  }

  $displayed_member = $displayed_member[0];

  $sidebar_menu_sections = yipnyap_members_get_settings_navigation_sections($displayed_member);

  set_query_var('member', $displayed_member);

  // if user settings page, load settings banner and sidebar
  if (bp_is_user_settings()) :

?>

<!-- CONTENT GRID -->
<div class="content-grid">
  <!-- GRID -->
  <!--
  Yeah, yeah. It's dirty way of making that footer stay below but whatever, man! I'll fix next version
  TODO: Remove this stupid thing.
  -->
  <div class="grid grid-3-9 medium-space" style="margin-bottom: 50vh;">
  <?php

    /**
     * Sidebar Menu
     */
    get_template_part('template-part/sidebar/sidebar-menu', null, [
      'sidebar_menu_sections' => $sidebar_menu_sections
    ]);

  else :
    $current_component = bp_current_component();

    $nav_items    = yipnyap_members_get_navigation_items($displayed_member);
    $subnav_items = yipnyap_member_bp_subnavigation_items_get($displayed_member, $current_component);

    set_query_var('member', $displayed_member);
    set_query_var('member_navigation_items', $nav_items);
    set_query_var('member_subnavigation_items', $subnav_items);
    set_query_var('current_component', $current_component);

    /**
     * Get members page header
     */
    bp_get_template_part('members/single/member-header');

  endif;

  /**
   * Get members page current template
   */
  if (bp_is_user_front()) {
    bp_displayed_user_front_template_part();
  } else if (bp_is_user_activity()) {
    bp_get_template_part('members/single/activity');

  } else if (bp_is_user_blogs()) {
    bp_get_template_part('members/single/blogs');

  } else if (bp_is_user_friends()) {
    bp_get_template_part('members/single/friends');

  } else if (bp_is_user_groups()) {
    bp_get_template_part('members/single/groups');

  } else if (bp_is_user_messages()) {
    bp_get_template_part('members/single/messages');

  } else if (bp_is_user_profile()) {
    bp_get_template_part('members/single/profile');

  } else if (bp_is_user_notifications()) {
    bp_get_template_part('members/single/notifications');

  } else if (bp_is_user_settings()) {
    bp_get_template_part('members/single/settings');

  } else {
    bp_get_template_part('members/single/plugins');

  }

  if (!bp_is_user_settings() && $subnav_items) {
  ?>

    </div>
    <!-- /GRID COLUMN -->
  </div>
  <!-- /GRID -->

  <?php
  }

?>
</div>
<!-- /CONTENT GRID -->
