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
<div id="cmui-entire-content" class="h-screen" style="overflow: hidden !important;"><?php
    }

    if (have_posts()) {
        the_post();
        the_content();
    } else {
        get_template_part('template-part/ng2-entrypoint/entrypoint');
    }

    get_footer();

    ?>
