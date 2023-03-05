<?php
/**
 * Yipnyap Template - BuddyPress Members Activity
 *
 * Displays a member activity feed
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

  $member = get_query_var('member');

  $friends = yipnyap_members_get(['user_id' => $member['id'], 'per_page' => 5]);

?>

<!-- GRID -->
<div class="grid grid-3-6-3">
  <!-- GRID COLUMN -->
  <div class="grid-column">
  <?php

    /**
     * Widget Info About
     */
    get_template_part('template-part/widget/widget-info', 'about', [
      'member' => $member
    ]);

    // if GamiPress plugin is active, show badges and quests widget
    if (yipnyap_plugin_gamipress_is_active()) {
      if (yipnyap_gamipress_achievement_type_exists('badge')) {
        /**
         * Widget Badges
         */
        get_template_part('template-part/widget/widget-badges', null, [
          'widget_title'  => esc_html__('Badges', 'yipnyap'),
          'badges'        => yipnyap_gamipress_get_user_completed_achievements('badge', $member['id'])
        ]);
      }

      if (yipnyap_gamipress_achievement_type_exists('quest')) {
        /**
         * Widget Quests
         */
        get_template_part('template-part/widget/widget-quests', null, [
          'widget_title'  => esc_html__('Quests', 'yipnyap'),
          'quests'        => yipnyap_gamipress_get_user_completed_achievements('quest', $member['id'])
        ]);
      }
    }

    // if the friends component is active, show friends widget
    if (bp_is_active('friends')) {
      /**
       * Widget User List
       */
      get_template_part('template-part/widget/widget-user-list', null, [
        'widget_title'    => esc_html__('Friends', 'yipnyap'),
        'users'           => $friends,
        'no_results_text' => esc_html__('No friends found', 'yipnyap'),
        'button'          => [
          'text'  => esc_html__('See all friends', 'yipnyap'),
          'link'  => bp_core_get_user_domain($member['id']) . 'friends'
        ]
      ]);
    }

  ?>
  </div>
  <!-- /GRID COLUMN -->

  <!-- ACTIVITY FILTERABLE LIST -->
  <div id="activity-filterable-list" class="grid-column" data-userid="<?php echo esc_attr($member['id']); ?>"></div>
  <!-- /ACTIVITY FILTERABLE LIST -->

  <!-- GRID COLUMN -->
  <div class="grid-column">
  <?php

    // if GamiPress plugin is active, show points widget
    if (yipnyap_plugin_gamipress_is_active()) {
      /**
       * Widget Points
       */
      get_template_part('template-part/widget/widget-points', null, [
        'widget_title'  => esc_html__('Credits Balance', 'yipnyap'),
        'points'        => yipnyap_gamipress_get_user_points($member['id'])
      ]);
    }

    // if the groups component is active, show groups widget
    if (bp_is_active('groups')) {
      $user_groups = yipnyap_groups_get(['user_id' => $member['id'], 'type' => 'popular', 'per_page' => 5]);

      /**
       * Widget Group List Tabbed
       */
      get_template_part('template-part/widget/widget-group-list', null, [
        'widget_title'    => esc_html__('Groups', 'yipnyap'),
        'groups'          => $user_groups,
        'no_results_text' => esc_html__('No groups found', 'yipnyap'),
        'button'          => [
          'text'  => esc_html__('See all groups', 'yipnyap'),
          'link'  => bp_core_get_user_domain($member['id']) . 'groups'
        ]
      ]);
    }

  ?>
  </div>
  <!-- /GRID COLUMN -->
</div>
<!-- /GRID -->
