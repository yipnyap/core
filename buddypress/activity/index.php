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

$user = vikinger_get_logged_user_member_data();
?>

<!-- CONTENT GRID -->

<div class="content-grid" style="padding-top: <?php if ($user) {
                                                echo "2em";
                                              } else {
                                                echo "";
                                              } ?>;">
  <?php

  $page_header_status = get_theme_mod('vikinger_pageheader_setting_display', 'display');

  if ($page_header_status === 'display') {
    $activity_header_icon_id      = get_theme_mod('vikinger_pageheader_activity_setting_image', false);
    $activity_header_title        = get_theme_mod('vikinger_pageheader_activity_setting_title', esc_html_x('Newsfeed', 'Activity Page - Title', 'vikinger'));
    $activity_header_description  = get_theme_mod('vikinger_pageheader_activity_setting_description', esc_html_x('Check what your friends have been up to!', 'Activity Page - Description', 'vikinger'));

    if ($activity_header_icon_id) {
      $activity_header_icon_url = wp_get_attachment_image_src($activity_header_icon_id, 'full')[0];
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

  <?php if ($user) { ?>
    <!-- Digital Wellbeing Header -->
    <div class="widget-box shadow" style="margin-top:80px;background-color: var(--color-box-background);padding:0;">
      <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
        <div class="py-6 md:flex md:items-center md:justify-between">
          <div class="flex-1 min-w-0">
            <!-- Profile -->
            <div class="flex items-center">
              <img class="hidden h-16 w-16 rounded-full sm:block" src="<?php echo esc_url($user['avatar_url']); ?>" alt="">
              <div>
                <div class="flex items-center">
                  <img class="h-16 w-16 rounded-full sm:hidden" src="<?php echo esc_url($user['avatar_url']); ?>" alt="">
                  <h1 id="mixheader-timed-greeting" class="ml-3 text-2xl font-bold leading-7 sm:leading-9 sm:truncate">
                    [greeting], <?php echo $user['name'] ?>
                  </h1>
                </div>
                <dl class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap">
                  <?php if ($user['verified']) { ?>
                    <dt class="sr-only">Verified status</dt>
                    <dd class="mt-3 flex items-center text-sm font-medium sm:mr-6 sm:mt-0 capitalize" style="color: var(--color-text-alt);">
                      <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                      </svg>
                      Verified account
                    </dd>
                  <?php } ?>

                  <dt class="sr-only">Important notices</dt>
                  <dd class="mt-3 flex items-center text-sm font-medium sm:mr-6 sm:mt-0" style="color: var(--color-text-alt);">
                    The "Following" tab is still unfunctional and displays everything.
                  </dd>
                </dl>
              </div>
            </div>
          </div>
          <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4" style="height: 3em;">
            <a href="https://forms.gle/F3nrztaU1hov8cme6" target="_blank" class="button inline-flex items-center px-4 py-2 shadow-sm text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500">
              Join Slack
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <!-- GRID -->
  <div class="grid grid-3-6-3 mobile-prefer-content">
    <!-- GRID COLUMN -->
    <div class="grid-column">
      <?php

      $online_members = vikinger_members_get(['type' => 'online', 'per_page' => 5]);

      /**
       * Widget Online User List Tabbed
       */
      get_template_part('template-part/widget/widget-user-list', null, [
        'widget_title'    => esc_html__('Online', 'vikinger'),
        'widget_subtext'  => esc_html__('Showing latest 5', 'vikinger'),
        'users'           => $online_members,
        'no_results_text' => esc_html__('No members found', 'vikinger')
      ]);

      $active_members = vikinger_members_get(['type' => 'active', 'per_page' => 10]);

      /**
       * Widget Recently Active User List Tabbed
       */
      get_template_part('template-part/widget/widget-user-list', null, [
        'widget_title'    => esc_html__('Recently Active', 'vikinger'),
        'users'           => $active_members,
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
      <!-- debug_user_account -->
      <?php if (isset($_GET['debug_user_account'])) { ?>
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
          <p class="alert-line-text"><?php echo var_dump($user) ?>
            <!-- /ALERT LINE TEXT -->
        </div>
      <?php } ?>

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