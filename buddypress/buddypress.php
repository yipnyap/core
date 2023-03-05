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
<div id="cmui-entire-content" class="h-screen" style="overflow: hidden !important;">
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
    the_content();
}

get_footer();

?>
