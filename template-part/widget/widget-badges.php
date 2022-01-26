<?php
/**
 * Yipnyap Template Part - Widget Badges
 *
 * @param array $args {
 * @type string $widget_title Widget title.
 * @type array $badges Badges data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_gamipress_get_achievements
 *
 * @package Yipnyap
 */

?>

<!-- WIDGET BOX -->
<div class="widget-box">
    <!-- WIDGET BOX TITLE -->
    <p class="widget-box-title"><?php echo esc_html($args['widget_title']); ?> <span
                class="highlighted"><?php echo esc_html(count($args['badges'])); ?></span></p>
    <!-- /WIDGET BOX TITLE -->

    <!-- WIDGET BOX CONTENT -->
    <div class="widget-box-content">
        <?php

        if (count($args['badges']) > 0) :
            /**
             * Badge List
             */
            get_template_part('template-part/badge/badge', 'list', [
                'badges' => $args['badges'],
                'modifiers' => 'align-left'
            ]);
        else :

            ?>
            <p class="no-results-text"><?php esc_html_e('No Badges Unlocked', 'yipnyap'); ?></p>
        <?php

        endif;

        ?>
    </div>
    <!-- /WIDGET BOX CONTENT -->
</div>
<!-- /WIDGET BOX -->
