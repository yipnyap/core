<?php
/**
 * Yipnyap Template Part - Achievement Preview List
 *
 * @param array $args {
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

<!-- ACHIEVEMENT PREVIEW LIST -->
<div class="achievement-preview-list">
    <?php

    foreach ($args['achievements'] as $achievement) {
        /**
         * Achievement Preview
         */
        get_template_part('template-part/achievement/achievement-preview', null, [
            'achievement' => $achievement
        ]);
    }

    ?>
</div>
<!-- /ACHIEVEMENT PREVIEW LIST -->
