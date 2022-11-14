<?php /** @noinspection PhpUnused */
/**
 * Yipnyap - Functions
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */
/**
 * Theme paths and urls
 */
define('YIPNYAP_PATH', get_template_directory());
define('YIPNYAP_URL', get_template_directory_uri());
define('YIPNYAP_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/yipnyap');
define('YIPNYAP_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/yipnyap');

require_once YIPNYAP_PATH . '/includes/utils/discord_webhook.php';

/**
 * Rename "Keymaster" role
 * Unfortunately, this is hard set by Wordpress, and I cannot change it from a plugin right now.
 * TODO: Replace this with a separate, configurable plugin later.
 */
add_filter('bbp_get_dynamic_roles', 'ntwb_bbpress_custom_role_names');

/** @noinspection PhpUndefinedFunctionInspection */
function ntwb_bbpress_custom_role_names(): array
{
    return array(

        // Keymaster
        bbp_get_keymaster_role() => array(
            'name' => 'Staff',
            'capabilities' => bbp_get_caps_for_role(bbp_get_keymaster_role())
        ),

        // Moderator
        bbp_get_moderator_role() => array(
            'name' => 'Moderator',
            'capabilities' => bbp_get_caps_for_role(bbp_get_moderator_role())
        ),

        // Participant
        bbp_get_participant_role() => array(
            'name' => 'Participant',
            'capabilities' => bbp_get_caps_for_role(bbp_get_participant_role())
        ),

        // Spectator
        bbp_get_spectator_role() => array(
            'name' => 'Spectator',
            'capabilities' => bbp_get_caps_for_role(bbp_get_spectator_role())
        ),

        // Blocked
        bbp_get_blocked_role() => array(
            'name' => 'Blocked',
            'capabilities' => bbp_get_caps_for_role(bbp_get_blocked_role())
        )
    );
}

/**
 * THEME CONSTANTS
 */
if (str_contains($_SERVER['SERVER_NAME'], 'local')) define('YIPNYAP_IS_LOCAL_DEV', true);
else define('YIPNYAP_IS_LOCAL_DEV', false);
$current_user = wp_get_current_user();

/**
 * Versioning
 */
define('YIPNYAP_DEVELOPER_VERSION', bin2hex(random_bytes(22)));
define('YIPNYAP_VERSION', YIPNYAP_IS_LOCAL_DEV ? ($current_user->user_login ?? 'build_is_unlicensed') . '/' . YIPNYAP_DEVELOPER_VERSION
    : 'hk13-hf3-4');
//const YIPNYAP_VERSION = 'hk13';
const YIPNYAP_VERSION_OPTION = 'yipnyap_version';

/**
 * Change Wordpress Settings
 */
define('YIPNYAP_WPOPTIONS', array(
    'blogname' => 'Yipnyap',
    'blogdescription' => 'A furry safespace',
    'users_can_register' => true,

    /*
     * WORDPRESS WHAT???? LMAO????? "true" and "false" don't work
     *
     * Snowsuit is the backend of Yipnyap.
     * TODO: Change this to update based on an API response (i.e. "Health check"?)
     * ^ Possibly not, that will be called each time the page loads, which is a lot.
     * ^ Maybe have a cron job that updates it every 5 minutes or so?
     */
    'snowsuit_registration_allowed' => 'yes',
    'cmui_use_profile_as_colour_palette' => isset($_GET['cmui_use_profile_as_colour_palette']) ? 'yes' : 'no',
    'yipnyap_logo_url' => array(YIPNYAP_URL . '/img/logo/unicorn-' . rand(1, 15) . '-min.png'),
    'buddypress' => [
        'basedir' => WP_CONTENT_DIR . '/uploads',
        'baseurl' => WP_CONTENT_URL . '/uploads'
    ],
    'unicorn_engine' => [
        'settings_str' => [
            'disallow_bg_render_str' => 'prevent others backgrounds from rendering',
            'disallow_palette_render_str' => 'prevent others ui palette from rendering',
            'hide_customised_ui_str' => 'hide customised ui notice on others profiles'
        ]
    ]
));
const YIPNYAP_OPTIONS = array(
    'discord_webhook_url' => 'https://canary.discord.com/api/webhooks/1010297665432584212/AfxYH1F_ORaCQu371Q-KQowg2tg8t9qZgFlP-Uxp4Sfh0KqlGxPC_qzMzwrdmmdhzIq_',
);

foreach (get_object_vars((object)YIPNYAP_WPOPTIONS) as $key => $option) {
    $change_required = get_option($key) !== $option;
//    echo $key . ': ' . $option . ' | current: ' . get_option($key) . ' | change required: ' . $change_required . '<br>';
    if ($change_required && $option !== 'DEVTEST') {
        update_option($key, $option);
    }
}

/**
 * Disables BuddyPress' registration process and fallsback to WordPress' one.
 */
function yipnyap_disable_bp_registration(): void
{
    remove_action('bp_init', 'bp_core_wpsignup_redirect');
    remove_action('bp_screens', 'bp_core_screen_signup');
}
add_action('bp_loaded', 'yipnyap_disable_bp_registration');

function yipnyap_redirect_bp_signup_page(): string
{
    return bp_get_root_domain() . '/login/?action=register';
}
add_filter('bp_get_signup_page', "yipnyap_redirect_bp_signup_page");

/**
 * Remove the wordpress admin bar
 * @return void
 */
function yipnyap_remove_admin_bar(): void
{
    $current_user = wp_get_current_user();
    if (!current_user_can('see_admin_bar') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'yipnyap_remove_admin_bar');

/**
 * Redirect to login after reset password
 */
add_action('login_headerurl', function () {
    // Check if have submitted
    $confirm = (isset($_GET['action']) && $_GET['action'] == 'resetpass');

    if($confirm) {
        wp_redirect('/login');
        exit;
    }
});

/**
 * TRANSLATION functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-translation.php';

/**
 * Load admin styles and scripts
 */
function yipnyap_admin_load_scripts(): void
{
    // load fonts
    wp_enqueue_style('yipnyap-admin-fonts', 'https://fonts.googleapis.com/css?family=Nunito+Sans:400,500,600,700|Poppins:400,900&display=swap');

    // add custom stylesheets
    wp_enqueue_style('yipnyap-admin-styles', YIPNYAP_URL . '/src/css/admin-style.min.css', array(), '1.11.0');

    // add custom scripts
    wp_enqueue_script('yipnyap-admin-scripts', YIPNYAP_URL . '/src/js/admin.bundle.min.js', [], '3.8.1', true);

    // pass php variables to javascript file
    wp_localize_script('yipnyap-admin-scripts', 'yipnyap_constants', array(
        'yipnyap_admin_ajax_nonce' => wp_create_nonce('yipnyap_admin_ajax')
    ));

    // pass translation strings to javascript file
    wp_localize_script('yipnyap-admin-scripts', 'yipnyap_translation', yipnyap_translation_get());
}

add_action('admin_enqueue_scripts', 'yipnyap_admin_load_scripts');

/**
 * Load theme styles and scripts
 */
function yipnyap_load_scripts(): void
{
    // add EX script
    wp_enqueue_script('yapex-main-scripts', YIPNYAP_URL . '/src/js/source/yapsdk/ex.js', ['jquery'], YIPNYAP_VERSION, true);

    // get fonts
    $fonts = yipnyap_customizer_theme_fonts_get_for_enqueue();

    // load fonts
    wp_enqueue_style('yipnyap-fonts', 'https://fonts.googleapis.com/css?family=' . $fonts['primary'] . ':400,500,600,700|' . $fonts['secondary'] . ':400,900&display=swap');

    // add custom stylesheets
    wp_enqueue_style('yipnyap-simplebar-styles', get_template_directory_uri() . '/src/css/vendor/simplebar.css', [], '1.0.0');
    wp_enqueue_style('yipnyap-swiper-slider-styles', get_template_directory_uri() . '/src/css/vendor/swiper.min.css', [], '1.0.0');
    wp_enqueue_style('yapex-styles', get_template_directory_uri() . '/style.css', ['yipnyap-simplebar-styles', 'yipnyap-swiper-slider-styles'], YIPNYAP_VERSION);
    wp_enqueue_style('yapex-shared-styles', get_template_directory_uri() . '/src/css/yapsdk/ex-shared.css', [], YIPNYAP_VERSION);

    // get user custom theme fonts
    $custom_fonts = yipnyap_customizer_theme_fonts_get_style();

    // add user custom theme fonts
    wp_add_inline_style('yapex-styles', $custom_fonts);

    // get user custom theme colors
    $custom_colors = yipnyap_customizer_theme_colors_get();

    // add user custom theme colors
    wp_add_inline_style('yapex-styles', $custom_colors);

    // add plugins
    wp_enqueue_script('yipnyap-swiper-scripts', YIPNYAP_URL . '/src/js/source/vendor/swiper.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmaccordion-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_accordion.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmdropdown-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_dropdown.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmhexagon-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_hexagon.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmpopup-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_popup.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmprogressBar-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_progressBar.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmtab-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_tab.min.js', [], '1.0.0', true);
    wp_enqueue_script('yipnyap-xmtooltip-scripts', YIPNYAP_URL . '/src/js/source/vendor/xm_tooltip.min.js', [], '1.0.0', true);

    $yipnyap_main_scripts_dependencies = [
        'jquery',
        'yipnyap-swiper-scripts',
        'yipnyap-xmaccordion-scripts',
        'yipnyap-xmdropdown-scripts',
        'yipnyap-xmhexagon-scripts',
        'yipnyap-xmpopup-scripts',
        'yipnyap-xmprogressBar-scripts',
        'yipnyap-xmtab-scripts',
        'yipnyap-xmtooltip-scripts'
    ];

    $app_bundle_file = '/src/js/app.bundle.min.js';
    // add main script
    if (YIPNYAP_IS_LOCAL_DEV) $app_bundle_file = '/src/js/bundle/app.bundle.js';
    wp_enqueue_script('yipnyap-main-scripts', YIPNYAP_URL . $app_bundle_file, $yipnyap_main_scripts_dependencies, YIPNYAP_VERSION, true);

    global $yipnyap_settings;

    $yipnyap_settings = yipnyap_settings_get();

    if (has_custom_logo()) {
        $logo_id = get_theme_mod('custom_logo');
        $logo_url = wp_get_attachment_image_src($logo_id, 'full');
    } else {
        $logo_url = get_option('yipnyap_logo_url');
    }

    // pass php variables to javascript file
    wp_localize_script('yipnyap-main-scripts', 'yipnyap_constants', [
        'yipnyap_url' => YIPNYAP_URL,
        'home_url' => esc_url(home_url('/')),
        'ajax_url' => home_url('/sdk/'),
        'logout_url' => wp_logout_url('/activity'),
        'logo_url' => $logo_url[0],
        'wp_rest_nonce' => wp_create_nonce('wp_rest'),
        'yipnyap_ajax_nonce' => wp_create_nonce('yipnyap_ajax'),
        'rest_root' => esc_url_raw(rest_url()),
        'plugin_active' => yipnyap_plugin_get_required_plugins_activation_status(),
        'gamipress_badge_type_exists' => yipnyap_plugin_gamipress_is_active() && yipnyap_gamipress_achievement_type_exists('badge'),
        'colors' => yipnyap_customizer_theme_colors_get_array(),
        'settings' => $yipnyap_settings,
        'yipnyap_server_version' => YIPNYAP_VERSION
    ]);

    // pass translation strings to javascript file
    wp_localize_script('yipnyap-main-scripts', 'yipnyap_translation', yipnyap_translation_get());
}

add_action('wp_enqueue_scripts', 'yipnyap_load_scripts');

/**
 * Remove plugin styles that are not needed to reduce file queries
 */
function yipnyap_dequeue_styles(): void
{
    // remove BuddyPress styles
    wp_dequeue_style('bp-legacy-css');

    // remove GamiPress styles
    wp_dequeue_style('gamipress-css');
}

add_action('wp_enqueue_scripts', 'yipnyap_dequeue_styles', 20);

/**
 * Add body class filters
 */
function yipnyap_body_classes($classes)
{
    if (is_admin_bar_showing()) {
        $classes[] = 'yipnyap-top-space';
    }

    if (!is_user_logged_in()) {
        $classes[] = 'yipnyap-logged-out';
    }

    return $classes;
}

add_filter('body_class', 'yipnyap_body_classes');

add_filter('admin_title', 'my_admin_title', 10, 2);
function my_admin_title($admin_title, $title): string
{
    // get_bloginfo('name')
    return 'Houndboard &bull; ' . $title;
}

/**
 * Add support for features
 */
function yipnyap_support_features(): void
{
    add_theme_support('post-formats', array('video', 'audio', 'gallery'));

    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');

    // Set content width.
    global $content_width;

    if (!isset($content_width)) {
        $content_width = 800;
    }

    // add post thumbnails support
    add_theme_support('post-thumbnails');

    // Set post thumbnail size.
    set_post_thumbnail_size(584);

    // Add custom image sizes used in post versions cover.
    add_image_size('yipnyap-postlist-thumb', 40, 40, true);
    add_image_size('yipnyap-postv1-fullscreen', 1980);
    add_image_size('yipnyap-postv2-fullscreen', 1184);

    // bbPress images
    add_post_type_support('forum', 'thumbnail');
    add_image_size('yipnyap-forum-thumb', 64, 64, true);

    // WooCommerce support
    add_theme_support('woocommerce');
    // WooCommerce gallery support
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'yipnyap_support_features');

/**
 * Remove uneeded classes that Wordpress (and plugins) generate.
 * They were for detecting plugins in the admin area, however there
 * better standard ways of doing this now.
 *
 * @param $wp_classes
 * @param $extra_classes
 * @return array New classes.
 */
function yipnyap_body_class($wp_classes, $extra_classes): array
{
    // List of the only WP generated classes allowed
    $whitelist = array('portfolio', 'home', 'error404');

    // Filter the body classes
    $wp_classes = array_intersect($wp_classes, $whitelist);

    // Add the extra classes back untouched
    return array_merge($wp_classes, (array)$extra_classes);
}

add_filter('body_class', 'yipnyap_body_class', 10, 2);

/**
 * Hide admin bar for non administrators
 */
$admin_bar_status = get_theme_mod('yipnyap_adminbar_setting_display', 'hide');

if (($admin_bar_status === 'hide') && !current_user_can('administrator')) {
    show_admin_bar(false);
}

/**
 * Yipnyap functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions.php';

/**
 * Yipnyap filters
 */
require_once YIPNYAP_PATH . '/includes/filters/filters.php';

/**
 * Yipnyap AJAX
 */
require_once YIPNYAP_PATH . '/includes/ajax/ajax.php';

/**
 * Yipnyap sidebars
 */
require_once YIPNYAP_PATH . '/includes/sidebars/sidebars.php';

/**
 * Yipnyap customizer
 */
require_once YIPNYAP_PATH . '/includes/customizer/customizer.php';

/**
 * PHP Autoloader
 */
function yipnyap_class_autoloader($class_name): void
{
    $base_path = YIPNYAP_PATH . '/includes/classes';

    // utils classes
    $utils_path = $base_path . '/utils';
    $utils_classes = ['Yipnyap_Scheduler', 'Yipnyap_Task'];

    foreach ($utils_classes as $utils_class) {
        if ($class_name === $utils_class) {
            require $utils_path . '/' . $class_name . '.php';
        }
    }
}

spl_autoload_register('yipnyap_class_autoloader');

/**
 * Allow the use of wp_redirect / wp_safe_redirect after headers are sent (after the get_header() function is called)
 */
function yipnyap_allow_redirect_after_header(): void
{
    ob_start();
}

add_action('init', 'yipnyap_allow_redirect_after_header');

/**
 * Setup member cover preferred image size
 */
function yipnyap_members_cover_image_setup($settings = [])
{
    // dimension settings
    $settings['width'] = 1184;
    $settings['height'] = 300;

    return $settings;
}

add_filter('bp_before_members_cover_image_settings_parse_args', 'yipnyap_members_cover_image_setup', 10, 1);

/**
 * Setup group cover preferred image size
 */
function yipnyap_group_cover_image_setup($settings = [])
{
    // dimension settings
    $settings['width'] = 1184;
    $settings['height'] = 300;

    return $settings;
}

add_filter('bp_before_groups_cover_image_settings_parse_args', 'yipnyap_group_cover_image_setup', 10, 1);

/**
 * Disable Gravatar
 */
add_filter('bp_core_fetch_avatar_no_grav', '__return_true');

/**
 * Set default member avatar
 */
function yipnyap_set_default_member_avatar(): string
{
    $members_default_avatar_url = yipnyap_get_default_member_avatar_url();

    return $members_default_avatar_url;
}

add_filter('bp_core_default_avatar_user', 'yipnyap_set_default_member_avatar');

/**
 * Set default group avatar
 */
function yipnyap_set_default_group_avatar(): string
{
    $groups_default_avatar_url = yipnyap_get_default_group_avatar_url();

    return $groups_default_avatar_url;
}

add_filter('bp_core_default_avatar_group', 'yipnyap_set_default_group_avatar');

/**
 * Load translations
 */
function yipnyap_translations_load(): void
{
    load_theme_textdomain('yipnyap', YIPNYAP_PATH . '/languages');
}

add_action('after_setup_theme', 'yipnyap_translations_load');

add_filter('login_title', function ($login_title) {
    return str_replace(array(' &lsaquo;', ' &#8212; WordPress', __('WordPress'),), array(' &lsaquo;', ''), $login_title);
});

/*
 * Replace Wordpress' error message generator with a custom.
 */
add_filter(
    'wp_php_error_message',
    function ($message, $error) {
        global $wp_filter;

        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        $date = date('c', strtotime('now'));
        $YIPNYAP_VERSION = YIPNYAP_VERSION;
        $new_error = substr($error['message'], 0, 100) . '...';
        // . '<br><br>' . $error["message"]

        postDiscordWebhookAsError(array(
            'content' => 'Houndkit crashed.',
            'embeds' => [
                [
                    'title' => 'ERRT-' . $error['type'] . '-' . $error['line'],
                    'description' => "Yipnyap Version {$YIPNYAP_VERSION}\n{$actual_link}\n```bash\n" . $error["message"] . "```",
                    'timestamp' => $date,
                ],
            ],
        ));

        return 'Houndkit crashed.<br><br>ERRT-' . $error['type'] . ' @ ' . $date . ' : ' . $actual_link . '<br><br>current hooks in session: ' . count($wp_filter);
    },
    10,
    2
);

function my_retrieve_password_subject_filter($old_subject): string
{
    // $old_subject is the default subject line created by WordPress.
    // (You don't have to use it.)

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $subject = sprintf(__('[%s] Password Reset'), $blogname);
    // This is how WordPress creates the subject line. It looks like this:
    // [Doug's blog] Password Reset
    // You can change this to fit your own needs.

    // You have to return your new subject line:
    return $subject;
}

function my_retrieve_password_message_filter($old_message, $key, $user_login): string
{
    // $old_message is the default message already created by WordPress.
    // (You don't have to use it.)
    // $key is the password-like token that allows the user to get
    // a new password

    $message = __('Someone has asked to reset the password your Kukiko ID.') . "\r\n\r\n";
//  $message .= network_site_url() . "\r\n\r\n";
//  $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
    $message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.') . "\r\n\r\n";
    $message .= __('If you\'re getting these emails often, please contact our support: https://yipnyap.atlassian.net/servicedesk') . "\r\n\r\n";
    $message .= network_site_url('wp-login.php?action=rp&key=' . $key . '&login=' . rawurlencode($user_login), 'login') . "\r\n";

    // This is how WordPress creates the message.
    // You can change this to meet your own needs.

    // You have to return your new message:
    return $message;
}

// To get these filters up and running:
add_filter('retrieve_password_title', 'my_retrieve_password_subject_filter', 10, 1);
add_filter('retrieve_password_message', 'my_retrieve_password_message_filter', 10, 3);

/* Remove wp_generator */
remove_action('wp_head', 'wp_generator');

add_filter('bp_core_enable_root_profiles', '__return_true');

// This changes /no-admin-ajax/ -> /sdk/
const WP_NO_ADMIN_AJAX_URL = 'sdk';
add_filter('no-admin-ajax/keyword', function () {
    return 'sdk';
});

// This will replace the 'wp-json' REST API prefix with 'api'.
// Be sure to flush your rewrite rules for this change to work.
add_filter('rest_url_prefix', function () {
    return 'api';
});

/*
 * Now time for the fun stuff. Manipulating buddypress to do
 * what we want. Mwa ha ha ha.
 */

// Dont save activities of types
function yipnyap_dont_save_activity($activity_object): void
{
    $exclude = array('new_avatar', 'updated_profile', 'friendship_created', 'created_group', 'joined_group', 'new_member');

    if (in_array($activity_object->type, $exclude))
        $activity_object->type = false;

}

add_action('bp_activity_before_save', 'yipnyap_dont_save_activity', 1, 1);

// Change the cover upload directory to our custom one
function yipnyap_cover_image_upload_dir($upload): array
{
    $base_dir = YIPNYAP_WPOPTIONS['buddypress']['basedir'] . '/';
    $path = $base_dir . $upload['subdir'];
    $url = YIPNYAP_WPOPTIONS['buddypress']['baseurl'] . $upload['subdir'];

    return array(
        'path' => $path,
        'url' => $url,
        'subdir' => $upload['subdir'],
        'basedir' => $base_dir,
        'baseurl' => YIPNYAP_WPOPTIONS['buddypress']['baseurl'],
        'error' => false
    );
}

add_filter('bp_attachments_cover_image_upload_dir', 'yipnyap_cover_image_upload_dir', 1, 1);

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
add_action('after_setup_theme', function() {
    // remove SVG and global styles
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
    remove_action( 'wp_body_open', 'gutenberg_global_styles_render_svg_filters' );

    // remove wp_footer actions which add's global inline styles
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);

    // remove render_block filters which adding unnecessary stuff
    remove_filter('render_block', 'wp_render_duotone_support');
    remove_filter('render_block', 'wp_restore_group_inner_container');
    remove_filter('render_block', 'wp_render_layout_support_flag');
});

// Set limits for the number of characters in bio and textboxes
function yipnyap_set_xprofile_character_limit($validated, $values, $field) {
    $allowed_len = 0;

    if ($field instanceof BP_XProfile_Field_Type_Textarea) {
        $allowed_len = 512;
    } elseif ($field instanceof BP_XProfile_Field_Type_Textbox) {
        $allowed_len = 32;
    }

    if ($allowed_len) {
        $validated = strlen($values) < $allowed_len;
    }

    return $validated;
}

add_filter('bp_xprofile_field_type_is_valid', 'yipnyap_set_xprofile_character_limit', 10, 3);
