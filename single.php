<?php
/**
 * Yipnyap Template - Singular
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

get_header();

if (have_posts()) {
    the_post();

    $post_type = get_post_type();

    $gp_post_types = [];

    if (yipnyap_plugin_gamipress_is_active()) {
        $gp_post_types = yipnyap_gamipress_post_types_get();
    }

    // if a GamiPress post type, show different template
    if (in_array($post_type, $gp_post_types)) {
        $post = get_post();

        $gp_type = yipnyap_gamipress_type_get($post_type);

        ?>

        <!-- CONTENT GRID -->
        <div class="content-grid">
            <!-- GRID -->
            <div class="grid grid-6-6 centered">
                <?php

                $user_points = yipnyap_gamipress_get_logged_user_points();

                if ($gp_type === 'achievement') {
                    $post_data = yipnyap_gamipress_get_achievement($post->ID, get_current_user_id());
                } else if ($gp_type === 'rank') {
                    $post_data = yipnyap_gamipress_get_rank($post->ID, get_current_user_id());
                }

                /** @var object $post_data */
                $achievement_args = [
                    'achievement' => $post_data,
                    'user_points' => $user_points,
                    'achievement_complete_info' => true,
                    'achievement_type' => $post_type,
                    'achievement_image_wrap' => $post_type === 'quest'
                ];

                /**
                 * Achievement Item Box
                 */
                get_template_part('template-part/achievement/achievement', 'item-box', $achievement_args);

                ?>
            </div>
            <!-- /GRID -->
        </div>
        <!-- /CONTENT GRID -->
        <?php
    } else {

        $post_data = yipnyap_post_get_loop_data();

        /**
         * Post Open V1, V2 or V3
         */
        get_template_part('template-part/post/post-open', $post_data['type'], [
            'post' => $post_data
        ]);
    }
}

get_footer();

?>
