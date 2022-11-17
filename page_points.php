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
