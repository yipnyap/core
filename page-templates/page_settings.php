<?php
// TODO: Redirect back here after login
if (!is_user_logged_in()) {
    return wp_redirect('/login');
}

get_header(null, [
        'selfControlCMUI' => true,
]);
?>
<div id="cmui-entire-content" class="lg:pl-20" style="height: calc(100% - 64px); overflow: hidden !important;">

<div class="h-full" id="nextgen-settings-page"></div>

<?php get_footer(); ?>

