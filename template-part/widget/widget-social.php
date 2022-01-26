<?php
/**
 * Yipnyap Template Part - Widget Social
 *
 * @param array $args {
 * @type string $widget_title Widget title.
 * @type array $social_links Badges data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get_xprofile_social_links, yipnyap_groups_meta_get_social_links
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

        if (count($args['social_links']) > 0) :
            /**
             * Social Links
             */
            get_template_part('template-part/social/social-links', null, [
                'social_links' => $args['social_links'],
                'modifiers' => 'multiline align-left small'
            ]);
        else :

            ?>
            <p class="no-results-text"><?php esc_html_e('No Social Networks Linked', 'yipnyap'); ?></p>
        <?php

        endif;

        ?>
    </div>
    <!-- /WIDGET BOX CONTENT -->
</div>
<!-- /WIDGET BOX -->
