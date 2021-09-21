<?php
/**
 * Yipnyap Template - BuddyPress Activity Index
 * 
 * Displays activity feed (all members activities)
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php

  $page_header_status = get_theme_mod('vikinger_pageheader_setting_display', 'display');

  if ($page_header_status === 'display') {
    $activity_header_icon_id      = get_theme_mod('vikinger_pageheader_activity_setting_image', false);
    $activity_header_title        = get_theme_mod('vikinger_pageheader_activity_setting_title', esc_html_x('Newsfeed', 'Activity Page - Title', 'vikinger'));
    $activity_header_description  = get_theme_mod('vikinger_pageheader_activity_setting_description', esc_html_x('Check what your friends have been up to!', 'Activity Page - Description', 'vikinger'));

    if ($activity_header_icon_id) {
      $activity_header_icon_url = wp_get_attachment_image_src($activity_header_icon_id , 'full')[0];
    } else {
      $activity_header_icon_url = vikinger_customizer_activity_page_image_get_default();
    }

    /**
     * Section Banner
     */
    get_template_part('template-part/section/section', 'banner', [
      'section_icon_url'    => $activity_header_icon_url,
      'section_title'       => $activity_header_title,
      'section_description' => '<a style="text-decoration:underline;" href="https://yipnyap.xyz/guidelines">You can read them here</a>'
    ]);
  }
	
  $show_quests = false;
  $show_badges = false;

?>

  <!-- GRID -->
  <div class="grid grid-3-6-3 mobile-prefer-content">
    <!-- GRID COLUMN -->
    <div class="grid-column">
    <?php

      $online_members = vikinger_members_get(['type' => 'online', 'per_page' => 10]);

      /**
       * Widget User List Tabbed
       */
      get_template_part('template-part/widget/widget-user-list', null, [
        'widget_title'    => esc_html__('Online', 'vikinger'),
        'users'           => $online_members,
        'no_results_text' => esc_html__('No members found', 'vikinger')
      ]);

      // if GamiPress plugin is active, show quests widget
      if (vikinger_plugin_gamipress_is_active() && vikinger_gamipress_achievement_type_exists('quest')) {
        // display 5 random user quests
        $quests         = vikinger_gamipress_get_logged_user_achievements('quest');
        $quests_to_show = vikinger_get_random_items_from($quests, 5);

        /**
         * Widget Quests Preview
         */
        if ($show_quests) {
		  get_template_part('template-part/widget/widget-quests', 'preview', [
            'widget_title' => esc_html__('Quests', 'vikinger'),
            'achievements' => $quests_to_show
          ]);
		}
      }

    ?>
    </div>
    <!-- /GRID COLUMN -->

    <div class="grid-column">
    <div class="alert-line alert-line-info">
      <!-- ALERT LINE ICON WRAP -->
      <div class="alert-line-icon-wrap">
        <!-- ALERT LINE ICON -->
        <svg class="alert-line-icon icon-info">
          <use href="#svg-info"></use>
        </svg>
        <!-- /ALERT LINE ICON -->
      </div>
      <!-- /ALERT LINE ICON WRAP -->
      
      <!-- ALERT LINE TEXT -->
      <p class="alert-line-text"><span class="bold">Notice:</span> "Following" tab is currently unfunctional and may display everything.</p>
      <!-- /ALERT LINE TEXT -->
    </div>

    <!-- ACTIVITY FILTERABLE LIST -->
    <div id="activity-filterable-list" class="grid-column"></div>
    <!-- /ACTIVITY FILTERABLE LIST -->
    </div>

    <!-- GRID COLUMN -->
    <div class="grid-column">
    <?php

      // if the groups component is active, show groups widget
      if (bp_is_active('groups')) {
        $popular_groups = vikinger_groups_get(['type' => 'popular', 'per_page' => 10]);

        /**
         * Widget Group List Tabbed
         */
        get_template_part('template-part/widget/widget-group-list', null, [
          'widget_title'    => esc_html__('Popular Groups', 'vikinger'),
          'groups'          => $popular_groups,
          'no_results_text' => esc_html__('No groups found', 'vikinger')
        ]);
      }

      // if GamiPress plugin is active, show badges widget
      if (vikinger_plugin_gamipress_is_active() && vikinger_gamipress_achievement_type_exists('badge')) {
        // display 5 random user badges
        $badges         = vikinger_gamipress_get_logged_user_achievements('badge');
        $badges_to_show = vikinger_get_random_items_from($badges, 5);

        /**
         * Widget Badges Preview
         */
        if ($show_badges) {
		  get_template_part('template-part/widget/widget-badges', 'preview', [
            'widget_title' => esc_html__('Badges', 'vikinger'),
            'achievements' => $badges_to_show
          ]);
		}
      }

    ?>
    </div>
    <!-- /GRID COLUMN -->
  </div>
  <!-- /GRID -->
</div>
<!-- /CONTENT GRID -->