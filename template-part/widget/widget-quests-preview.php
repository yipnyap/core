<?php
/**
 * Yipnyap Template Part - Widget Quests Preview
 *
 * @param array $args {
 * @type string $widget_title Widget title.
 * @type array $achievements Achievements data.
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
    <p class="widget-box-title"><?php echo esc_html($args['widget_title']); ?></p>
    <!-- /WIDGET BOX TITLE -->

    <!-- WIDGET BOX CONTENT -->
    <div class="widget-box-content">
        <?php

        if (count($args['achievements']) > 0) :
            /**
             * Achievement Preview List
             */
            get_template_part('template-part/achievement/achievement-preview', 'list', [
                'achievements' => $args['achievements']
            ]);
        else :

            ?>
            <p class="no-results-text"><?php esc_html_e('No Quests Created', 'yipnyap'); ?></p>
        <?php
        endif;
        ?>
    </div>
    <!-- /WIDGET BOX CONTENT -->
</div>
<!-- /WIDGET BOX -->
