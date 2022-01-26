<?php
/**
 * Functions - GamiPress + BuddyPress - Actions
 *
 * @package Yipnyap
 *
 * @since 1.9.1
 *
 * @author Odin Design Themes (https://odindesignthemes.com/)
 *
 */

/**
 * Member Profile - Credits Page
 */
if (yipnyap_settings_members_profile_page_is_enabled('credits')) {
    if (!function_exists('yipnyap_members_credits_page_setup_nav')) {
        /**
         * Creates member credits page navigation
         */
        function yipnyap_members_credits_page_setup_nav()
        {
            global $bp;

            bp_core_new_nav_item([
                'name' => esc_html__('Credits', 'yipnyap'),
                'slug' => 'credits',
                'screen_function' => 'yipnyap_members_credits_page',
                'position' => yipnyap_member_bp_navigation_item_default_order_get('credits')
            ]);
        }
    }

    add_action('bp_setup_nav', 'yipnyap_members_credits_page_setup_nav');

    if (!function_exists('yipnyap_members_credits_page')) {
        /**
         * Members credits page setup
         */
        function yipnyap_members_credits_page()
        {
            add_action('bp_template_content', 'yipnyap_members_credits_page_screen_content');
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        }
    }

    if (!function_exists('yipnyap_members_credits_page_screen_content')) {
        /**
         * Members credits page HTML content
         */
        function yipnyap_members_credits_page_screen_content()
        {
            $member = get_query_var('member');
            $points = yipnyap_gamipress_get_user_points($member['id']);
            $point_count = count($points);

            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => sprintf(
                    esc_html_x('Browse %s', 'Section Header - Pretitle', 'yipnyap'),
                    $member['name']
                ),
                'section_title' => esc_html__('Credits Balance', 'yipnyap')
            ]);

            if ($point_count > 0) {
                ?>
                <div class="grid grid-3-3-3-3">
                    <?php

                    foreach ($points as $point) {
                        /**
                         * Point Item Box
                         */
                        get_template_part('template-part/point/point-item', 'box', [
                            'point' => $point
                        ]);
                    }

                    ?>
                </div>
                <?php
            }
        }
    }
}

/**
 * Member Profile - Badges Page
 */
if (yipnyap_settings_members_profile_page_is_enabled('badges') && yipnyap_gamipress_achievement_type_exists('badge')) {
    if (!function_exists('yipnyap_members_badges_page_setup_nav')) {
        /**
         * Creates member badges page navigation
         */
        function yipnyap_members_badges_page_setup_nav()
        {
            global $bp;

            bp_core_new_nav_item([
                'name' => esc_html__('Badges', 'yipnyap'),
                'slug' => 'badges',
                'screen_function' => 'yipnyap_members_badges_page',
                'position' => yipnyap_member_bp_navigation_item_default_order_get('badges')
            ]);
        }
    }

    add_action('bp_setup_nav', 'yipnyap_members_badges_page_setup_nav');

    if (!function_exists('yipnyap_members_badges_page')) {
        /**
         * Members badges page setup
         */
        function yipnyap_members_badges_page()
        {
            add_action('bp_template_content', 'yipnyap_members_badges_page_screen_content');
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        }
    }

    if (!function_exists('yipnyap_members_badges_page_screen_content')) {
        /**
         * Members badges page HTML content
         */
        function yipnyap_members_badges_page_screen_content()
        {
            $member = get_query_var('member');
            $badges = yipnyap_gamipress_get_user_completed_achievements('badge', $member['id']);
            $badges_count = count($badges);

            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => sprintf(
                    esc_html_x('Browse %s', 'Section Header - Pretitle', 'yipnyap'),
                    $member['name']
                ),
                'section_title' => esc_html__('Badges', 'yipnyap'),
                'section_text' => $badges_count
            ]);

            if ($badges_count > 0) {
                ?>
                <div class="grid grid-3-3-3-3">
                    <?php
                    foreach ($badges as $badge) {
                        /**
                         * Achievement Item Box
                         */
                        get_template_part('template-part/achievement/achievement', 'item-box', [
                            'achievement' => $badge
                        ]);
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
}

/**
 * Member Profile - Quests Page
 */
if (yipnyap_settings_members_profile_page_is_enabled('quests') && yipnyap_gamipress_achievement_type_exists('quest')) {
    if (!function_exists('yipnyap_members_quests_page_setup_nav')) {
        /**
         * Creates member quests page navigation
         */
        function yipnyap_members_quests_page_setup_nav()
        {
            global $bp;

            bp_core_new_nav_item([
                'name' => esc_html__('Quests', 'yipnyap'),
                'slug' => 'quests',
                'screen_function' => 'yipnyap_members_quests_page',
                'position' => yipnyap_member_bp_navigation_item_default_order_get('quests')
            ]);
        }
    }

    add_action('bp_setup_nav', 'yipnyap_members_quests_page_setup_nav');

    if (!function_exists('yipnyap_members_quests_page')) {
        /**
         * Members quests page setup
         */
        function yipnyap_members_quests_page()
        {
            add_action('bp_template_content', 'yipnyap_members_quests_page_screen_content');
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        }
    }

    if (!function_exists('yipnyap_members_quests_page_screen_content')) {
        /**
         * Members quests page HTML content
         */
        function yipnyap_members_quests_page_screen_content()
        {
            $member = get_query_var('member');
            $quests = yipnyap_gamipress_get_user_completed_achievements('quest', $member['id']);
            $quests_count = count($quests);

            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => sprintf(
                    esc_html_x('Browse %s', 'Section Header - Pretitle', 'yipnyap'),
                    $member['name']
                ),
                'section_title' => esc_html__('Quests', 'yipnyap'),
                'section_text' => $quests_count
            ]);

            if ($quests_count > 0) {
                ?>
                <div class="grid grid-3-3-3-3">
                    <?php
                    foreach ($quests as $quest) {
                        /**
                         * Achievement Item Box
                         */
                        get_template_part('template-part/achievement/achievement', 'item-box', [
                            'achievement' => $quest,
                            'achievement_image_wrap' => true
                        ]);
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
}

/**
 * Member Profile - Ranks Page
 */
if (yipnyap_settings_members_profile_page_is_enabled('ranks')) {
    if (!function_exists('yipnyap_members_ranks_page_setup_nav')) {
        /**
         * Creates member ranks page navigation
         */
        function yipnyap_members_ranks_page_setup_nav()
        {
            global $bp;

            bp_core_new_nav_item([
                'name' => esc_html__('Ranks', 'yipnyap'),
                'slug' => 'ranks',
                'screen_function' => 'yipnyap_members_ranks_page',
                'position' => yipnyap_member_bp_navigation_item_default_order_get('ranks')
            ]);
        }
    }

    add_action('bp_setup_nav', 'yipnyap_members_ranks_page_setup_nav');

    if (!function_exists('yipnyap_members_ranks_page')) {
        /**
         * Members ranks page setup
         */
        function yipnyap_members_ranks_page()
        {
            add_action('bp_template_content', 'yipnyap_members_ranks_page_screen_content');
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        }
    }

    if (!function_exists('yipnyap_members_ranks_page_screen_content')) {
        /**
         * Members ranks page HTML content
         */
        function yipnyap_members_ranks_page_screen_content()
        {
            $member = get_query_var('member');
            $ranks = yipnyap_gamipress_get_user_completed_ranks('rank', $member['id']);
            $ranks_count = count($ranks);

            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => sprintf(
                    esc_html_x('Browse %s', 'Section Header - Pretitle', 'yipnyap'),
                    $member['name']
                ),
                'section_title' => esc_html__('Rank', 'yipnyap')
            ]);

            if ($ranks_count > 0) {
                ?>
                <div class="grid grid-3-3-3-3">
                    <?php
                    foreach ($ranks as $rank) {
                        /**
                         * Achievement Item Box
                         */
                        get_template_part('template-part/achievement/achievement', 'item-box', [
                            'achievement' => $rank,
                            'achievement_type' => 'rank'
                        ]);
                    }
                    ?>
                </div>
                <?php
            }
        }
    }
}

?>
