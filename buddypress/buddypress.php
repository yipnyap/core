<?php
/**
 * Yipnyap Template - BuddyPress Entry Point
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */
$SelfControlCMUIPages = ['activity', 'photos', 'videos', 'badges', 'friends', 'arcana'];
$SelfControlCMUI = bp_is_user_activity() || in_array(bp_current_component(), $SelfControlCMUIPages);

get_header(null, [
        'selfControlCMUI' => $SelfControlCMUI
]);

if ($SelfControlCMUI) { ?>
<div id="cmui-entire-content" class="lg:pl-20" style="height: calc(100% - 64px); overflow: hidden !important;">
    <div class="h-full" id="nextgen-settings-page"></div>
    <?php
}

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
            <?php /** @var object $post_access_data */
            echo $post_access_data['message']; ?>
        </div>
        <!-- /CONTENT GRID -->
        <?php
    } else {
        the_content();
    }
}

get_footer();

?>
