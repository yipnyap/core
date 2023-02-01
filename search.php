<?php
/**
 * Yipnyap Template - Search
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

get_header();

$search_query = get_search_query();

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php
    global $yipnyap_settings;

    // add BuddyPress member search data if BuddyPress is active
    if (yipnyap_plugin_buddypress_is_active() && $yipnyap_settings['search_members_enabled']) :
        /**
         * Section Header
         */
        get_template_part('template-part/section/section', 'header', [
            'section_pretitle' => esc_html__('Browse', 'yipnyap'),
            'section_title' => esc_html__('Members', 'yipnyap')
        ]);

        $members_grid_type = yipnyap_logged_user_grid_type_get('member');

        ?>
        <!-- MEMBER FILTERABLE LIST -->
        <div id="member-filterable-list" class="filterable-list"
             data-searchterm="<?php echo esc_attr($search_query); ?>"
             data-grid-type="<?php echo esc_attr($members_grid_type); ?>"></div>
        <!-- /MEMBER FILTERABLE LIST -->
    <?php

    endif;

    // add BuddyPress group search data if BuddyPress and the groups component are active
    if (yipnyap_plugin_buddypress_is_active() && bp_is_active('groups') && $yipnyap_settings['search_groups_enabled']) :
        /**
         * Section Header
         */
        get_template_part('template-part/section/section', 'header', [
            'section_pretitle' => esc_html__('Browse', 'yipnyap'),
            'section_title' => esc_html__('Groups', 'yipnyap')
        ]);

        $groups_grid_type = yipnyap_logged_user_grid_type_get('group');

        ?>
        <!-- GROUP FILTERABLE LIST -->
        <div id="group-filterable-list" class="filterable-list" data-searchterm="<?php echo esc_attr($search_query); ?>"
             data-grid-type="<?php echo esc_attr($groups_grid_type); ?>"></div>
        <!-- /GROUP FILTERABLE LIST -->
    <?php

    endif;

    if ($yipnyap_settings['search_blog_enabled']) {

        $post_type_split_is_enabled = yipnyap_blog_post_type_split_display_is_enabled();

        if (!$post_type_split_is_enabled) {
            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => esc_html__('Browse', 'yipnyap'),
                'section_title' => esc_html__('Posts', 'yipnyap')
            ]);
        }

        /**
         * Post Filterable List
         */
        get_template_part('template-part/post/post-filterable-list', null, [
            'allow_post_types' => true,
            'post_types' => yipnyap_blog_post_types_to_display_in_search_get(),
            'attributes' => [
                'searchterm' => $search_query
            ]
        ]);

    }

    ?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
