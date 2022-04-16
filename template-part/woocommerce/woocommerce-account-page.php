<?php
/**
 * Yipnyap Template Part - WooCommerce Account Page
 *
 * @package Yipnyap
 * @since 1.6.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php

    if (yipnyap_plugin_buddypress_is_active()) {
        $page_header_status = get_theme_mod('yipnyap_pageheader_setting_display', 'hide');

        if ($page_header_status === 'display') {
            $settings_header_icon_id = get_theme_mod('yipnyap_pageheader_settings_setting_image', false);
            $settings_header_title = get_theme_mod('yipnyap_pageheader_settings_setting_title', esc_html_x('Account Hub', 'Settings Page - Title', 'yipnyap'));
            $settings_header_description = get_theme_mod('yipnyap_pageheader_settings_setting_description', esc_html_x('Profile info, notifications, friends, groups, messages and much more!', 'Settings Page - Description', 'yipnyap'));

            if ($settings_header_icon_id) {
                $settings_header_icon_url = wp_get_attachment_image_src($settings_header_icon_id, 'full')[0];
            } else {
                $settings_header_icon_url = yipnyap_customizer_settings_page_image_get_default();
            }

            /**
             * Section Banner
             */
            get_template_part('template-part/section/section', 'banner', [
                'section_icon_url' => $settings_header_icon_url,
                'section_title' => $settings_header_title,
                'section_description' => $settings_header_description
            ]);
        }
    }

    the_content();

    if (yipnyap_plugin_buddypress_is_active()) :

    ?>
</div>
<!-- /GRID -->
<?php

endif;

?>
</div>
<!-- /CONTENT GRID -->
