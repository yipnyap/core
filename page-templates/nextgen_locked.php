<?php
// TODO: Redirect back here after login
if (!is_user_logged_in()) {
    return wp_redirect('/login');
}

get_header(null, [
    'selfControlCMUI' => true,
]);
?>
    <div id="cmui-entire-content" class="h-screen" style="overflow: hidden !important;">
<?php
get_template_part('template-part/ng2-entrypoint/entrypoint');
get_footer();

