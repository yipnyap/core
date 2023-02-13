<?php
/**
 * Yipnyap Template Part - Information Block List
 *
 * @param array $args {
 * @type array $information_items Information items.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_xprofile_get_group_fields
 *
 * @package Yipnyap
 */

?>

<!-- INFORMATION BLOCK LIST -->
<div class="information-block-list">
    <?php

    foreach ($args['information_items'] as $information_item) {
        if ($information_item['value'] !== '') {
            /**
             * Information Block
             */
            get_template_part('template-part/information/information-block', null, [
                'information_item' => $information_item
            ]);
        }
    }

    ?>
</div>
<!-- /INFORMATION BLOCK LIST -->
