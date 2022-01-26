<?php
/**
 * Yipnyap Template Part - Point Item Box
 *
 * @param array $args {
 * @type array $point Point data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_gamipress_get_user_points
 *
 * @package Yipnyap
 */

?>

<!-- POINT ITEM BOX -->
<div class="point-item-box">
    <!-- POINT ITEM BOX IMAGE WRAP -->
    <div class="point-item-box-image-wrap">
        <!-- POINT ITEM BOX IMAGE -->
        <img class="point-item-box-image" src="<?php echo esc_url($args['point']['image_url']); ?>"
             alt="<?php echo esc_attr($args['point']['slug']); ?>">
        <!-- /POINT ITEM BOX IMAGE -->
    </div>
    <!-- /POINT ITEM BOX IMAGE WRAP -->

    <!-- POINT ITEM BOX TITLE -->
    <p class="point-item-box-title"><?php echo esc_html($args['point']['points']); ?></p>
    <!-- /POINT ITEM BOX TITLE -->

    <!-- POINT ITEM BOX SUBTITLE -->
    <p class="point-item-box-subtitle"><?php echo esc_html($args['point']['plural_name']); ?></p>
    <!-- /POINT ITEM BOX SUBTITLE -->

    <!-- POINT ITEM BOX TEXT -->
    <p class="point-item-box-text"><?php esc_html_e('Win this credits by unlocking badges or doing quests', 'yipnyap'); ?></p>
    <!-- /POINT ITEM BOX TEXT -->
</div>
<!-- /POINT ITEM BOX -->
