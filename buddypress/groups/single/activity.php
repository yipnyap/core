<?php
/**
 * Yipnyap Template - BuddyPress Groups Activity
 *
 * Displays a group activity feed
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

  $group = get_query_var('group');

?>

<!-- GRID -->
<div class="grid-legacy grid-3-6-3 mobile-prefer-content">
  <!-- GRID COLUMN -->
  <div class="grid-column">
    <?php

    $group_meta_args = [
      'group_id'  => $group['id']
    ];

    $group_meta = yipnyap_group_get_meta($group_meta_args);

    /**
     * Widget Social
     */
    get_template_part('template-part/widget/widget-social', null, [
      'widget_title'  => esc_html__('Social Networks', 'yipnyap'),
      'social_links'  => yipnyap_groups_meta_get_social_links($group_meta)
    ]);

    /**
     * Widget Info Group
     */
    get_template_part('template-part/widget/widget-info', 'group', [
      'group' => $group
    ]);

    $newest_members = yipnyap_groups_get_members(['group_id' => $group['id'], 'exclude_admins' => false, 'per_page' => 5]);

    /**
     * Widget User List
     */
    get_template_part('template-part/widget/widget-user-list', null, [
      'widget_title'    => esc_html__('Newest Members', 'yipnyap'),
      'users'           => $newest_members,
      'no_results_text' => esc_html__('No members found', 'yipnyap')
    ]);

  ?>
  </div>
  <!-- /GRID COLUMN -->

  <!-- ACTIVITY FILTERABLE LIST -->
  <div id="activity-filterable-list" class="grid-column" data-groupid="<?php echo esc_attr($group['id']); ?>"></div>
  <!-- /ACTIVITY FILTERABLE LIST -->

  <!-- GRID COLUMN -->
  <div class="grid-column">
  <?php

    $group_admins = yipnyap_get_group_admins($group['id']);

    /**
     * Widget User List
     */
    get_template_part('template-part/widget/widget-user-list', null, [
      'widget_title'  => esc_html__('Group Administrators', 'yipnyap'),
      'users'         => $group_admins
    ]);

    $group_mods = yipnyap_get_group_mods($group['id']);

    /**
     * Widget User List
     */
    get_template_part('template-part/widget/widget-user-list', null, [
      'widget_title'    => esc_html__('Group Moderators', 'yipnyap'),
      'users'           => $group_mods,
      'no_results_text' => esc_html__('This group doesn\'t have any moderators', 'yipnyap')
    ]);

  ?>
  </div>
  <!-- /GRID COLUMN -->
</div>
<!-- /GRID -->
