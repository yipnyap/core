<?php
/**
 * Yipnyap Template Part - Point Item Line List
 *
 * @param array $args {
 * @type array $points Points data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_gamipress_get_user_points
 *
 * @package Yipnyap
 */

?>

<!-- POINT ITEM LINE LIST -->
<div class="point-item-line-list">
    <?php foreach ($args['points'] as $point) : ?>
        <!-- POINT ITEM LINE -->
        <div class="point-item-line">
            <!-- POINT ITEM LINE IMAGE -->
            <img class="point-item-line-image" src="<?php echo esc_url($point['image_url']); ?>"
                 alt="<?php echo esc_attr($point['slug']); ?>">
            <!-- /POINT ITEM LINE IMAGE -->

            <!-- POINT ITEM LINE INFO -->
            <div class="point-item-line-info">
                <!-- POINT ITEM LINE TITLE -->
                <p class="point-item-line-title"><?php echo esc_html($point['points']); ?><?php echo esc_html($point['plural_name']); ?></p>
                <!-- /POINT ITEM LINE TITLE -->

                <!-- POINT ITEM LINE TEXT -->
                <p class="point-item-line-text"><?php esc_html_e('Current Balance', 'yipnyap') ?></p>
                <!-- /POINT ITEM LINE TEXT -->
            </div>
            <!-- POINT ITEM LINE INFO -->
        </div>
        <!-- /POINT ITEM LINE -->
    <?php endforeach; ?>
</div>
<!-- /POINT ITEM LINE LIST -->
