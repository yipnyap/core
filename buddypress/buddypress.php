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
<div id="cmui-entire-content" class="h-full" style="overflow: hidden !important;">
    <div class="h-full" id="ng2-entrypoint">
        <div class="flex w-full h-full m-auto">
            <img class="m-auto h-5 w-5 animate-spin dark:invert"
                 src="<?php echo YIPNYAP_URL . '/img/symbolic/process-working.symbolic.png' ?>"
                 alt="Process working spinner"/>
        </div>
    </div>
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
