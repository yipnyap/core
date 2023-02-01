<?php
/**
 * Template Name: Ranks Page
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

// check if rank unlock is submitted
$rank_unlock_submitted = isset($_POST['achievement_unlock']);

// if achievement unlock submitted
if ($rank_unlock_submitted) {
    $rank_unlock_id = absint($_POST['achievement_unlock_id']);
    $rank_unlocked = yipnyap_gamipress_unlock_logged_user_rank_with_points($rank_unlock_id);

    // Redirect to same page to avoid form resubmission
    $redirect_url = esc_url(home_url($wp->request));
    wp_safe_redirect($redirect_url);
    exit;
}

get_header();

$rank_type = 'rank';

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php
    $ranks = yipnyap_gamipress_get_logged_user_ranks($rank_type);
    $user_points = yipnyap_gamipress_get_logged_user_points();

    if (count($ranks)) :

        ?>
        <!-- GRID -->
        <div class="grid grid-3-3-3-3 medium-space centered-on-mobile grid-stretched">
            <?php

            foreach ($ranks as $rank) {
                $rank_args['achievement'] = $rank;

                /**
                 * Achievement Item Box
                 */
                get_template_part('template-part/achievement/achievement', 'item-box', [
                    'achievement' => $rank,
                    'user_points' => $user_points,
                    'achievement_complete_info' => true,
                    'achievement_type' => 'rank'
                ]);
            }

            ?>
        </div>
        <!-- /GRID -->
    <?php

    endif;

    ?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
