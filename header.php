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
    <?php wp_head(); ?>
</head>
<body class="dark h-screen" style="-webkit-font-smoothing: antialiased;">
<?php
wp_body_open();
