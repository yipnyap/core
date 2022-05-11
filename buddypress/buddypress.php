<?php
/**
 * Yipnyap Template - BuddyPress Entry Point
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

get_header();

if (have_posts()) {
    the_post();

    $logged_user_has_membership_access = true;

    if (yipnyap_plugin_pmpro_is_active()) {
        $post_access_data = yipnyap_pmpro_post_access_data_get();
        $logged_user_has_membership_access = $post_access_data['accessible'];
    }

    if (!$logged_user_has_membership_access) {
        ?>
        <!-- CONTENT GRID -->
        <div class="content-grid">
            <?php echo $post_access_data['message']; ?>
        </div>
        <!-- /CONTENT GRID -->
        <?php
    } else {
        the_content();
    }
}

get_footer();

?>
