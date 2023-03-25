<?php
/**
 * Remove the WordPress login & Register pages
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since ui1
 */
add_action('init', function () {
    $current = $_SERVER['REQUEST_URI'];
    if ((str_starts_with($current, '/login') || str_starts_with($current, '/wp-login')) && $_GET['action'] != 'logout') {
        wp_redirect('/id/login');
        exit();
    } elseif (str_starts_with($current, '/register') || str_starts_with($current, '/wp-login')) {
        wp_redirect('/id/create');
        exit();
    }
});

/**
 * Stop WordPress from guessing the correct URL
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since ui1.2
 */
add_filter('do_redirect_guess_404_permalink', function () {
    return false;
});

/**
 * Remove the WordPress Heartbeat API
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since ui1.4
 */
add_action('init', function () {
    wp_deregister_script('heartbeat');
}, 1);

/**
 * Kill the WordPress Feed page
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since ui2
 */
add_action('init', function () {
    unset($GLOBALS['wp_rewrite']->feeds[array_search('feed', $GLOBALS['wp_rewrite']->feeds)]);
});

/**
 * Remove REST API & oEmbed Discovery links from header
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
add_action('after_setup_theme', function (): void {
    // Disable REST API link tag
    remove_action('wp_head', 'rest_output_link_wp_head');

    // Disable oEmbed Discovery Links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Disable REST API link in HTTP headers
    remove_action('template_redirect', 'rest_output_link_header', 11);
});

/**
 * Remove the wordpress admin bar.
 * Some reason, it only works when you use both of these functions.
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
show_admin_bar(false);
add_filter('show_admin_bar', '__return_false');

/**
 * Remove the Wordpress version from the header
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
remove_action('wp_head', 'wp_generator');

/**
 * Alter the backend title
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
add_filter('admin_title', function (string $admin_title, string $title): string {
    return 'Houndboard • ' . $title;
}, 10, 2);

/**
 * Remove uneeded classes that Wordpress (and plugins) generate.
 * They were for detecting plugins in the admin area, however there
 * better standard ways of doing this now.
 *
 * @param $wp_classes
 * @param $extra_classes
 * @return array New classes.
 */
add_filter('body_class', function ($wp_classes, $extra_classes): array {
    // List of the only WP generated classes allowed
    $whitelist = ['portfolio', 'home', 'error404'];

    // Filter the body classes
    $wp_classes = array_intersect($wp_classes, $whitelist);

    // Add the extra classes back untouched
    return array_merge($wp_classes, (array) $extra_classes);
}, 10, 2);

/**
 * Change WordPress' login title
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
add_filter('login_title', function ($login_title) {
    return str_replace([' &lsaquo;', ' &#8212; WordPress', __('WordPress'),], [' &lsaquo;', ''], $login_title);
});

/**
 * Replace Wordpress' error message generator with a custom.
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
add_filter('wp_php_error_message', function ($message, $error) {
    global $wp_filter;

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
    $date = date('c', strtotime('now'));
    $YIPNYAP_VERSION = YIPNYAP_VERSION;
    $new_error = substr($error['message'], 0, 200) . '...';
    // . '<br><br>' . $error["message"]

//        postDiscordWebhookAsError([
//            'content' => 'Houndkit crashed.',
//            'embeds' => [
//                [
//                    'title' => 'ERRT-' . $error['type'] . '-' . $error['line'],
//                    'description' => "Yipnyap Version {$YIPNYAP_VERSION}\n{$actual_link}\n```bash\n" . $error["message"] . "```",
//                    'timestamp' => $date,
//                ],
//            ],
//        ]);

    return 'Houndkit crashed. Please contact the developer. <br><br>' . $new_error;
}, 10, 2);

/**
 * Change ajax & rest urls to more standard ones.
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
// This changes /no-admin-ajax/ -> /sdk/
const WP_NO_ADMIN_AJAX_URL = 'sdk';
add_filter('no-admin-ajax/keyword', function () {
    return 'sdk';
});

// This changes /wp-json/ -> /api/
add_filter('rest_url_prefix', function () {
    return 'api';
});

/**
 * Remove Gutenberg
 *
 * @return void
 * @package Yipnyap WP Beheadding
 * @since hk15
 */
/* Again, wordpress, respectfully, i hope you die in the
 * fiery pits of hell from where you came. Wordpress,
 * for some reason, will not allow you to remove its
 * stupid "Gutenberg" editor, as well as it's own emoji
 * handler, and for some reason it's picker. So, we have
 * to do this. This will remove it's bullsh*ttery from
 * pages (EVEN THOUGH WE USE IT LITERALLY NOWHERE!!!???)
 *
 * Let me add to the pain: it loads SVGs and scripts,
 * that are loaded *from s.w.org*, their CDN, with a unique
 * UUID, that's only supposed to be used when you have blog
 * federation on (we do not). This entire time i was
 * disobeying our own Privacy Policy because wordpress
 * decided to be quirky different 🤪✌️
 *
 * At this point with all these modifications, we've
 * basically made our own Wordpres fork. Can't wait for
 * snow2 so we can just ditch this shit.
 * Kill me now :)
 *
 * ^Rek(t)
 */
add_action('after_setup_theme', function () {
    // remove SVG and global styles
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
    remove_action('wp_body_open', 'gutenberg_global_styles_render_svg_filters');

    // remove wp_footer actions which add's global inline styles
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // remove render_block filters which adding unnecessary stuff
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block', 'wp_restore_group_inner_container');
    remove_filter('render_block', 'wp_render_layout_support_flag');

    // Just remove the whole thing
    remove_action('enqueue_block_editor_assets', 'gutenberg_editor_scripts_and_styles');
});
