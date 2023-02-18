<?php
get_header(null, [
    'selfControlCMUI' => true,
]);
?>
<div id="cmui-entire-content" class="h-full" style="overflow: hidden !important;">
    <div class="h-full" id="ng2-entrypoint">
        <div class="flex w-full h-full m-auto">
            <img class="m-auto h-5 w-5 animate-spin dark:invert"
                 src="<?php echo YIPNYAP_URL . '/img/symbolic/process-working.symbolic.png' ?>"
                 alt="Process working spinner"/>
        </div>
    </div>

    <?php get_footer(); ?>

