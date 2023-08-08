<?php
/**
 * Yipnyap Template - Index
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */
get_header(null, [
    'selfControlCMUI' => true,
]);
?>

<div id="cmui-entire-content" class="h-screen" style="overflow: hidden !important;">
    <?php get_template_part('template-part/ng2-entrypoint/entrypoint'); ?>
</div>

<?php get_footer(); ?>
