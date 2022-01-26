<?php
/**
 * Template Name: Points Page
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

// get achievement page data
$queried_object = get_queried_object();

$title = $queried_object->post_title;
$description = wp_strip_all_tags($queried_object->post_content);
$slug = $queried_object->post_name;

get_header();

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php

    $page_header_status = get_theme_mod('yipnyap_pageheader_setting_display', 'display');

    if ($page_header_status === 'display') {
        $point_header_icon_id = get_theme_mod('yipnyap_pageheader_point_setting_image', false);
        $point_header_title = get_theme_mod('yipnyap_pageheader_point_setting_title', esc_html_x('Credits', 'Credits Page - Title', 'yipnyap'));
        $point_header_description = get_theme_mod('yipnyap_pageheader_point_setting_description', esc_html_x('Browse all the credits of the community!', 'Credits Page - Description', 'yipnyap'));

        if ($point_header_icon_id) {
            $point_header_icon_url = wp_get_attachment_image_src($point_header_icon_id, 'full')[0];
        } else {
            $point_header_icon_url = yipnyap_customizer_point_page_image_get_default();
        }

        /**
         * Section Banner
         */
        get_template_part('template-part/section/section', 'banner', [
            'section_icon_url' => $point_header_icon_url,
            'section_title' => $point_header_title,
            'section_description' => $point_header_description
        ]);
    }

    $points = yipnyap_gamipress_get_logged_user_points();

    if ($points) :
        /**
         * Section Header
         */
        get_template_part('template-part/section/section', 'header', [
            'section_pretitle' => esc_html__('Browse your', 'yipnyap'),
            'section_title' => esc_html__('Credits Balance', 'yipnyap')
        ]);

        ?>
        <!-- GRID -->
        <div class="grid grid-3-3-3-3 centered-on-mobile">
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
        <!-- /GRID -->
    <?php

    endif;

    /**
     * Credits Awards
     */
    $point_types_awards = yipnyap_gamipress_get_point_type_awards();

    if ($point_types_awards) :
        /**
         * Section Header
         */
        get_template_part('template-part/section/section', 'header', [
            'section_pretitle' => esc_html__('Complete tasks!', 'yipnyap'),
            'section_title' => esc_html__('Credits Awards', 'yipnyap')
        ]);
        ?>
        <div class="grid grid-half">
            <?php

            foreach ($point_types_awards as $point_type_awards) {
                foreach ($point_type_awards as $point_type_award) {
                    /**
                     * Point Reward Box
                     */
                    get_template_part('template-part/point/point-reward', 'box', [
                        'point' => $point_type_award
                    ]);
                }
            }

            ?>
        </div>
    <?php

    endif;

    /**
     * Credits Deducts
     */
    $point_types_deducts = yipnyap_gamipress_get_point_type_deducts();

    if ($point_types_deducts) :
        /**
         * Section Header
         */
        get_template_part('template-part/section/section', 'header', [
            'section_pretitle' => esc_html__('Watch out for', 'yipnyap'),
            'section_title' => esc_html__('Credits Deducts', 'yipnyap')
        ]);
        ?>
        <div class="grid grid-half">
            <?php

            foreach ($point_types_deducts as $point_type_deducts) {
                foreach ($point_type_deducts as $point_type_deduct) {
                    /**
                     * Point Reward Box
                     */
                    get_template_part('template-part/point/point-reward', 'box', [
                        'point' => $point_type_deduct,
                        'point_type' => 'deduct'
                    ]);
                }
            }

            ?>
        </div>
    <?php

    endif;

    ?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
