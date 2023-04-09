<?php
/**
 * Yipnyap Template - Header
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> lang="en-AU">
<!--suppress HtmlRequiredTitleElement -->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php if (has_site_icon()) : ?>
        <!-- favicon -->
        <link rel="icon" href="<?php site_icon_url(); ?>">
    <?php endif; ?>
    <script src='https://telegram.org/js/telegram-widget.js?21'></script>
    <script src='https://betteruptime.com/widgets/announcement.js' data-id='159526' async='async'
            type='text/javascript'></script>
    <?php wp_head(); ?>
</head>
<body class="dark h-screen" style="-webkit-font-smoothing: antialiased;">
<?php
wp_body_open();

if (current_user_can('administrator') || current_user_can('moderator')) { ?>
    <div id="yapex-moderator-toggle"></div>
<?php } ?>

    <?php

    $loading_screen_status = get_theme_mod('yipnyap_loadingscreen_setting_display', 'hide');

    if ($loading_screen_status === 'display') :

        ?>
        <!-- PAGE LOADER -->
        <div class="page-loader">
            <?php

            $loading_screen_logo_id = get_theme_mod('yipnyap_loadingscreen_setting_logo', false);
            $loading_screen_logo_url = false;

            if ($loading_screen_logo_id) {
                $loading_screen_logo_url = wp_get_attachment_image_src($loading_screen_logo_id, 'full')[0];
            } else if (has_custom_logo()) {
                $loading_screen_logo_id = get_theme_mod('custom_logo');
                $loading_screen_logo_url = wp_get_attachment_image_src($loading_screen_logo_id, 'full')[0];
            }

            if ($loading_screen_logo_url) :

                ?>
                <!-- PAGE LOADER LOGO -->
                <img class="page-loader-logo" src="<?php echo esc_url($loading_screen_logo_url); ?>" alt="logo">
                <!-- /PAGE LOADER LOGO -->
            <?php

            endif;

            ?>
            <!-- PAGE LOADER INFO -->
            <div class="page-loader-info">
                <!-- PAGE LOADER INFO TITLE -->
                <p class="page-loader-info-title"><?php bloginfo('name'); ?></p>
                <!-- /PAGE LOADER INFO TITLE -->

                <!-- PAGE LOADER INFO TEXT -->
                <p class="page-loader-info-text"><?php echo esc_html_x('Loading...', 'Loading Screen - Text', 'yipnyap'); ?></p>
                <!-- /PAGE LOADER INFO TEXT -->
            </div>
            <!-- /PAGE LOADER INFO -->

            <!-- PAGE LOADER INDICATOR -->
            <div class="page-loader-indicator loader-bars">
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
                <div class="loader-bar"></div>
            </div>
            <!-- /PAGE LOADER INDICATOR -->
        </div>
        <!-- /PAGE LOADER -->
    <?php

    endif;

    if (!bp_is_register_page() && !bp_is_activation_page()) {

        $user = yipnyap_get_logged_user_member_data('user-sidebar', true);

        // get header menu data, they display whether the user is logged in or not
        $header_menu_items = yipnyap_menu_get_items('header_menu')['threaded'];
        $header_features_menu_items = yipnyap_menu_get_items('header_features_menu')['threaded'];
        $header_features_menu_items = yipnyap_menu_group_by_parent($header_features_menu_items);

        $side_menu_items = yipnyap_menu_get_items('side_menu');
        $side_menu_items_threaded = $side_menu_items['threaded'];
        $side_menu_items_flat = $side_menu_items['flat'];

        $yipnyap_settings = yipnyap_settings_get();

        // if a user is logged in, show logged in header
        if ($user) {
            $points = yipnyap_gamipress_get_user_points($user['id']);

            // get logged user header menu and navigation data
            $settings_navigation_sections = yipnyap_members_get_settings_navigation_sections($user);


            /**
             * Header Logged In
             */
            get_template_part('template-part/header/header', 'cmui', [
                'user' => $user,
                'points' => $points,
                'side_menu_items' => $side_menu_items_threaded,
                'side_menu_items_flat' => $side_menu_items_flat,
                'header_menu_items' => $header_menu_items,
                'header_features_menu_items' => $header_features_menu_items,
                'settings_navigation_sections' => $settings_navigation_sections,
                'selfControlCMUI' => $args['selfControlCMUI'] ?? false,
            ]);
        } else {
            /**
             * Header Logged Out
             */
            get_template_part('template-part/header/header', 'cmui', [
                'header_menu_items' => $header_menu_items,
                'header_features_menu_items' => $header_features_menu_items,
                'side_menu_items' => $side_menu_items_threaded,
                'side_menu_items_flat' => $side_menu_items_flat,
                'yipnyap_settings' => $yipnyap_settings,
                'selfControlCMUI' => $args['selfControlCMUI'] ?? false
            ]);
        }
    }

    ?>
