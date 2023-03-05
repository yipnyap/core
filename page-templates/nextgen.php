<?php
get_header(null, [
    'selfControlCMUI' => true,
]);
?>
    <div id="cmui-entire-content" class="h-screen" style="overflow: hidden !important;">
<?php
get_template_part('template-part/ng2-entrypoint/entrypoint');
get_footer();

