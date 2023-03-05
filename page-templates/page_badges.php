<?php
/**
 * Template Name: Badges Page
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

// check if achievement unlock is submitted
$achievement_unlock_submitted = isset($_POST['achievement_unlock']);

// if achievement unlock submitted
if ($achievement_unlock_submitted) {
    $achievement_unlock_id = absint($_POST['achievement_unlock_id']);
    $achievement_unlocked = yipnyap_gamipress_unlock_logged_user_achievement_with_points($achievement_unlock_id);

    /**
     * Redirect to same page to avoid form resubmission.
     *
     * $wp is global to WordPress, and is an instance of WP.
     * @see https://developer.wordpress.org/reference/classes/wp/
     *
     */
    if (!empty($wp)) {
        $redirect_url = esc_url(home_url($wp->request));
        wp_safe_redirect($redirect_url);
    }
    exit;
}

get_header();

$achievement_type = 'badge';

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php
    $achievements = yipnyap_gamipress_get_logged_user_achievements($achievement_type);
    $user_points = yipnyap_gamipress_get_logged_user_points();

    if (count($achievements)) :

        ?>
        <!-- GRID -->
        <div class="grid-legacy grid-3-3-3-3 medium-space centered-on-mobile grid-stretched">
            <?php

            $achievement_args = [
                'user_points' => $user_points,
                'achievement_complete_info' => true
            ];

            if ($achievement_type === 'quest') {
                $achievement_args['achievement_image_wrap'] = true;
            }

            foreach ($achievements as $achievement) {
                $achievement_args['achievement'] = $achievement;

                /**
                 * Achievement Item Box
                 */
                get_template_part('template-part/achievement/achievement', 'item-box', $achievement_args);
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
