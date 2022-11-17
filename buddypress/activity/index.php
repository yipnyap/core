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

$user = yipnyap_get_logged_user_member_data();
?>

<!-- CONTENT GRID -->

<div class="content-grid <?php if ($user) echo 'signed-in' ?>" style="padding: 0 !important;">
    <?php

    $show_quests = false;
    $show_badges = false;

    ?>

    <?php if ( /* $user */ false) { ?>
        <!-- Digital Wellbeing Header -->
        <nav class="hidden shadow mixnav">
            <!-- Timed background -->
            <div data-time="day" class="bgimg" data-geo="city"></div>

            <!-- Time greet content -->
            <div class="hidden md:block px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
                <div class="py-6 md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <!-- Profile -->
                        <div class="flex items-center">
                            <img src="<?php echo $user["avatar_url"] ?>" alt=""
                                 class="hidden h-12 w-12 rounded-default sm:block"/>
                            <div>
                                <!-- Profile greet and username -->
                                <div class="flex items-center">
                                    <!-- Different picture placement on smaller screens -->
                                    <img src="<?php echo $user["avatar_url"] ?>" alt=""
                                         class="h-12 w-12 rounded-default sm:hidden"/>
                                    <h1
                                            id="mixheader-timed-greeting"
                                            class="ml-3 text-2xl font-bold leading-7 text-cool-gray-900 sm:leading-9 sm:truncate">
                                        Yipnyap is loading, <?php echo $user['name'] ?>
                                    </h1>
                                </div>

                                <!-- Flair, Verified, and "Do More with Yipnyap" headers -->
                                <dl class="mt-6 flex flex-col sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap">
                                    <!-- Group Flair -->
                                    <dt *ngIf="user.public?.flair" class="sr-only">Flair</dt>
                                    <dd *ngIf="user.public?.flair"
                                        class="flex items-center text-sm leading-5 text-cool-gray-500 font-medium capitalize sm:mr-6">
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-cool-gray-400" fill="currentColor"
                                             viewBox="0 0 20 20">
                                            <path clip-rule="evenodd"
                                                  d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z"
                                                  fill-rule="evenodd"/>
                                        </svg>
                                        <span class="text-hint">No group flair</span>
                                    </dd>

                                    <!-- Verified Flair -->
                                    <?php if ($user['verified']) { ?>
                                        <dt class="sr-only">Verified status</dt>
                                        <dd class="mt-3 flex items-center text-sm font-medium sm:mr-6 sm:mt-0 capitalize"
                                            style="color: var(--color-text-alt);">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400"
                                                 x-description="Heroicon name: solid/check-circle"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor"
                                                 aria-hidden="true">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                            Verified account
                                        </dd>
                                    <?php } ?>

                                    <!-- Do more CTA -->
                                    <!-- <dd *ngIf="!user.public?.flair && !user.attributes?.verified"
                                        class="flex items-center text-sm leading-5 text-cool-gray-500 font-medium capitalize sm:mr-6">
                                        <a [routerLink]="['/settings', 'general']"
                                            class="font-medium text-primary hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                            Do more with Yipnyap &rarr;
                                        </a>
                                    </dd> -->
                                </dl>
                            </div>
                        </div>
                    </div>

                    <!-- Profile quick actions -->
                    <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
                    <span class="shadow-sm rounded-default">
                        <a href="<?php echo $user["link"] . 'settings' ?>" class="ypsdk button-upgrade">
                            Edit
                        </a>
                    </span>
                        <span class="shadow-sm rounded-default">
                        <a href="https://discord.gg/wrCGpAB" target="_blank" class="ypsdk button-upgrade"
                           color="primary">
                            Discord
                        </a>
                    </span>
                    </div>
                </div>
            </div>
        </nav>
    <?php } ?>

    <?php if (!$user) {
        if (bp_has_activities(array(
            'show_hidden' => true,
            'count_total' => true
        ))) {
            global $activities_template;
            $postCount = $activities_template->total_activity_count;
        } else {
            $postCount = 0;
        }
        ?>
        <div id="cmui-landing-activity-header"></div>
    <?php } ?>

    <div id="activity-notice"></div>

    <!-- GRID -->
    <div class="grid-cols-4 xl:grid-cols-8 gap-4" style="display: grid;">
        <!-- LEFT COLUMN -->
        <div class="hidden col-span-2 xl:block">
            <?php

            $online_members = yipnyap_members_get(['type' => 'online', 'per_page' => 15, 'hide_system' => true]);
            $active_members = yipnyap_members_get(['type' => 'active', 'per_page' => 20, 'hide_system' => true]);

            /**
             * Widget Recently Active User List Tabbed
             */
            get_template_part('template-part/widget/widget-user-list-tabbed', null, [
                'widget_title' => esc_html__('Online Users', 'yipnyap'),
                'tabs' => [
                    [
                        'title' => 'Online Now',
                        'users' => $online_members,
                        'no_results_text' => esc_html__('Nobody is online!', 'yipnyap')
                    ],
                    [
                        'title' => 'Recent',
                        'users' => $active_members,
                        'no_results_text' => esc_html__('Something went wrong.', 'yipnyap')
                    ]
                ],
            ]);

            // if GamiPress plugin is active, show quests widget
            if (yipnyap_plugin_gamipress_is_active() && yipnyap_gamipress_achievement_type_exists('quest')) {
                // display 5 random user quests
                $quests = yipnyap_gamipress_get_logged_user_achievements('quest');
                $quests_to_show = yipnyap_get_random_items_from($quests, 5);

                /**
                 * Widget Quests Preview
                 */
                if ($show_quests) {
                    get_template_part('template-part/widget/widget-quests', 'preview', [
                        'widget_title' => esc_html__('Quests', 'yipnyap'),
                        'achievements' => $quests_to_show
                    ]);
                }
            }

            ?>
        </div>
        <!-- /LEFT COLUMN -->

        <div class="col-span-4 space-y-4">
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
                    <pre class="alert-line-text"><?php echo print_r($user) ?></pre>
                    <!-- /ALERT LINE TEXT -->
                </div>
            <?php } ?>

            <?php if (isset($_GET['debug_limithtml'])) { ?>
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
                    <p class="alert-line-text">Limit.HTML v0<br><br>[Allowlist] => <?php echo allowed_tags() ?></p>
                    <!-- /ALERT LINE TEXT -->
                </div>
            <?php } ?>

            <!-- ACTIVITY FILTERABLE LIST -->
            <div id="activity-filterable-list" class="grid-column"></div>
            <!-- /ACTIVITY FILTERABLE LIST -->
        </div>

        <!-- GROUPS COLUMN -->
        <div class="hidden col-span-2 xl:block">
            <?php

            // if the groups component is active, show groups widget
            if (bp_is_active('groups')) {
                $popular_groups = yipnyap_groups_get(['type' => 'popular', 'per_page' => 10]);

                /**
                 * Widget Group List Tabbed
                 */
                get_template_part('template-part/widget/widget-group-list', null, [
                    'widget_title' => esc_html__('Popular Groups', 'yipnyap'),
                    'groups' => $popular_groups,
                    'no_results_text' => esc_html__('No groups found', 'yipnyap')
                ]);
            }

            // if GamiPress plugin is active, show badges widget
            if (yipnyap_plugin_gamipress_is_active() && yipnyap_gamipress_achievement_type_exists('badge')) {
                // display 5 random user badges
                $badges = yipnyap_gamipress_get_logged_user_achievements('badge');
                $badges_to_show = yipnyap_get_random_items_from($badges, 5);

                /**
                 * Widget Badges Preview
                 */
                if ($show_badges) {
                    get_template_part('template-part/widget/widget-badges', 'preview', [
                        'widget_title' => esc_html__('Badges', 'yipnyap'),
                        'achievements' => $badges_to_show
                    ]);
                }
            }

            ?>
        </div>
        <!-- /GROUPS COLUMN -->
    </div>
    <!-- /GRID -->
</div>
<!-- /CONTENT GRID -->
