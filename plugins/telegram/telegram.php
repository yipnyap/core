<?php
/**
 * Plugin Name: OTP via Telegram
 * Description: This plugin enables two factor authentication with Telegram.
 * Version: 1.0.0
 * Author: Yipnyap
 * Text Domain: yipnyap-telegram
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */
if (!defined('ABSPATH')) {
    die;
}

/**
 *
 * Full path to the WP Two Factor Telegram File
 *
 */
const WP_FACTOR_TG_FILE = __FILE__;
const WP_FACTOR_TG_GETME_TRANSIENT = 'tg_wp_factor_valid_bot';

/**
 *
 * The main plugin class
 *
 */
require_once("includes/class-wp-factor-telegram-plugin.php");

function WFT(): WP_Factor_Telegram_Plugin
{
    return WP_Factor_Telegram_Plugin::get_instance();
}

WFT();

