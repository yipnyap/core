<?php /** @noinspection PhpUnused */
/**
 * Yipnyap - Functions
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

// Load Nextgen 2 Debugger
require_once __DIR__ . '/global/nextgen2/debug.php';

// Load plugins bundled with theme
require_once __DIR__ . '/plugins/plugins.php';

/**
 * Count render time
 */
// Start
$AnalyticalRenderTime = [
    'start' => microtime(true),
    'end' => 0,
    'total' => 0,
    'human' => 0,
];

// Hook into the 'wp_footer' action
add_action('wp_footer', function() {
    global $AnalyticalRenderTime;
    // End
    $AnalyticalRenderTime['end'] = microtime(true);

    // Calculate
    $AnalyticalRenderTime['total'] = $AnalyticalRenderTime['end'] - $AnalyticalRenderTime['start'];
    $AnalyticalRenderTime['human'] = number_format($AnalyticalRenderTime['total'], 2);

    // Send render time to client
    echo console_log($AnalyticalRenderTime);
});

/**
 * After theme loaded, load page templates
 */
add_action('after_setup_theme', function() {
    // Load init.php
    require_once get_template_directory() . '/page-templates/init.php';
});

/**
 * Theme paths and urls
 */
define('YIPNYAP_PATH', get_template_directory());
define('YIPNYAP_URL', get_template_directory_uri());
define('YIPNYAP_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/yipnyap');
define('YIPNYAP_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/yipnyap');

require_once YIPNYAP_PATH . '/includes/utils/discord_webhook.php';
require_once YIPNYAP_PATH . '/wp-beheadding/index.php';

/**
 * Rename "Keymaster" role
 * Unfortunately, this is hard set by Wordpress, and I cannot change it from a plugin right now.
 * TODO: Replace this with a separate, configurable plugin later.
 */
add_filter('bbp_get_dynamic_roles', 'ntwb_bbpress_custom_role_names');

/** @noinspection PhpUndefinedFunctionInspection */
function ntwb_bbpress_custom_role_names(): array
{
    return [

        // Keymaster
        bbp_get_keymaster_role() => [
            'name' => 'Staff',
            'capabilities' => bbp_get_caps_for_role(bbp_get_keymaster_role())
        ],

        // Moderator
        bbp_get_moderator_role() => [
            'name' => 'Moderator',
            'capabilities' => bbp_get_caps_for_role(bbp_get_moderator_role())
        ],

        // Participant
        bbp_get_participant_role() => [
            'name' => 'Participant',
            'capabilities' => bbp_get_caps_for_role(bbp_get_participant_role())
        ],

        // Spectator
        bbp_get_spectator_role() => [
            'name' => 'Spectator',
            'capabilities' => bbp_get_caps_for_role(bbp_get_spectator_role())
        ],

        // Blocked
        bbp_get_blocked_role() => [
            'name' => 'Blocked',
            'capabilities' => bbp_get_caps_for_role(bbp_get_blocked_role())
        ]
    ];
}

/**
 * THEME CONSTANTS
 */
define('YIPNYAP_IS_LOCAL_DEV', str_contains($_SERVER['SERVER_NAME'], 'local') || str_contains($_SERVER['SERVER_NAME'], 'ngrok'));

/**
 * Versioning
 */
define('YIPNYAP_DEVELOPER_VERSION', bin2hex(random_bytes(8)));
const YIPNYAP_VERSION = YIPNYAP_IS_LOCAL_DEV
    ? 'linkbleed/' . YIPNYAP_DEVELOPER_VERSION
    : 'ui1.3';
const YIPNYAP_VERSION_OPTION = 'yipnyap_version';

/**
 * Change Wordpress Settings
 */
define('YIPNYAP_WPOPTIONS', [
    'blogname' => 'Yipnyap',
    'blogdescription' => 'A furry safespace',
    'users_can_register' => true,

    /*
     * WORDPRESS WHAT???? LMAO????? "true" and "false" don't work
     */
    'cmui_use_profile_as_colour_palette' => isset($_GET['cmui_use_profile_as_colour_palette']) ? 'yes' : 'no',
    'yipnyap_logo_url' => YIPNYAP_URL . '/img/logo/unicorn-' . rand(1, 15) . '-min.png',
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
    ],
    'google_font_url' => 'https://fonts.googleapis.com/css2?family=Lexend:wght@300..700',
    'fonts' => [
        'primary' => 'Lexend',
        'secondary' => 'Lexend'
    ],
]);
const YIPNYAP_OPTIONS = [
    'discord_webhook_url' => 'https://canary.discord.com/api/webhooks/1010297665432584212/AfxYH1F_ORaCQu371Q-KQowg2tg8t9qZgFlP-Uxp4Sfh0KqlGxPC_qzMzwrdmmdhzIq_',
];

foreach (get_object_vars((object)YIPNYAP_WPOPTIONS) as $key => $option) {
    $change_required = get_option($key) !== $option;
//    echo $key . ': ' . $option . ' | current: ' . get_option($key) . ' | change required: ' . $change_required . '<br>';
    if ($change_required && ($option !== 'DEVTEST' || $key !== 'yipnyap_logo_url')) {
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
    wp_enqueue_style('yipnyap-admin-fonts', 'https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900&display=swap');

    // add custom stylesheets
    wp_enqueue_style('yipnyap-admin-styles', YIPNYAP_URL . '/src/css/admin-style.min.css', [], '1.11.0');

    // pass php variables to javascript file
    wp_localize_script('yipnyap-admin-scripts', 'yipnyap_constants', [
        'yipnyap_admin_ajax_nonce' => wp_create_nonce('yipnyap_admin_ajax')
    ]);

    // pass translation strings to javascript file
    wp_localize_script('yipnyap-admin-scripts', 'yipnyap_translation', yipnyap_translation_get());
}

add_action('admin_enqueue_scripts', 'yipnyap_admin_load_scripts');

/**
 * Load theme styles and scripts
 */

add_action('wp_enqueue_scripts', function () {
    // add EX script
    wp_enqueue_script('yapex-main-scripts', YIPNYAP_URL . '/src/js/source/yapsdk/ex.js', ['jquery'], YIPNYAP_VERSION, true);

    // load fonts
    wp_enqueue_style('yipnyap-fonts', get_option('google_font_url'));

    // add custom stylesheets
//    wp_enqueue_style('yipnyap-simplebar-styles', get_template_directory_uri() . '/src/css/vendor/simplebar.css', [], '1.0.0');
//    wp_enqueue_style('yipnyap-swiper-slider-styles', get_template_directory_uri() . '/src/css/vendor/swiper.min.css', [], '1.0.0');
    wp_enqueue_style('yapex-shared-styles', get_template_directory_uri() . '/src/css/yapsdk/ex-shared.css', [], YIPNYAP_VERSION);

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

    foreach (glob(get_template_directory() . '/dist/*.js') as $file) {
        // remove the directory path from $file
        $file = basename($file);

        $domain = get_template_directory_uri() . '/dist/';
        if (YIPNYAP_IS_LOCAL_DEV) $domain = 'http://localhost:9000/';
        wp_enqueue_script($file, $domain . $file, [], YIPNYAP_VERSION, true);
    }

    foreach (glob(get_template_directory() . '/dist/*.css') as $file) {
        // remove the directory path from $file
        $file = basename($file);

        $domain = get_template_directory_uri() . '/dist/';
        if (YIPNYAP_IS_LOCAL_DEV) $domain = 'http://localhost:9000/';
        wp_enqueue_style($file, $domain . $file, [], YIPNYAP_VERSION);
    }

    global $yipnyap_settings;

    $yipnyap_settings = yipnyap_settings_get();

//    if (has_custom_logo()) {
//        $logo_id = get_theme_mod('custom_logo');
//        $logo_url = wp_get_attachment_image_src($logo_id, 'full');
//    } else {
//        $logo_url = get_option('yipnyap_logo_url');
//    }

    // pass php variables to window object
    $yipnyap_constants = [
        'yipnyap_url' => YIPNYAP_URL,
        'home_url' => esc_url(home_url('/')),
        'ajax_url' => home_url('/sdk/'),
        'logout_url' => wp_logout_url('/'),
        'logo_url' => YIPNYAP_WPOPTIONS['yipnyap_logo_url'],
        'wp_rest_nonce' => wp_create_nonce('wp_rest'),
        'yipnyap_ajax_nonce' => wp_create_nonce('yipnyap_ajax'),
        'rest_root' => esc_url_raw(rest_url()),
        'plugin_active' => yipnyap_plugin_get_required_plugins_activation_status(),
        'gamipress_badge_type_exists' => yipnyap_plugin_gamipress_is_active() && yipnyap_gamipress_achievement_type_exists('badge'),
        'colors' => yipnyap_customizer_theme_colors_get_array(),
        'settings' => $yipnyap_settings,
        'yipnyap_server_version' => YIPNYAP_VERSION,
        'upload_url' => wp_upload_dir()['baseurl'],
        'telegram_bot' => get_option('tg_col') ?? explode(':', get_option('tg_col')['bot_token'])[0],
        'notices' => [
            'tgLink' => "@rekkisomo: Due to an issue with Telegram's Login Widget, you can't link Telegram right now. We're working to fix this issue, conversing with Telegram Support. Sorry for the inconvenience 😔",
        ]
    ];
    ?>
    <script>
        window.yipnyap_constants = <?php echo json_encode($yipnyap_constants); ?>;
        window.yipnyap_translation = <?php echo json_encode(yipnyap_translation_get()); ?>;
    </script>
    <?php
    // pass translation strings to javascript file
    wp_localize_script('yipnyap-main-scripts', 'yipnyap_translation', yipnyap_translation_get());
});

add_filter('script_loader_tag', function ($tag, $handle) {
    // if handle contains 'gami', 'bp-', don't add it
    if (str_contains($handle, 'gamipress-') || str_contains($handle, 'bp-')) {
        return '';
    }

    if ($handle !== 'bundle.js') {
        return $tag;
    }

    return str_replace(' src', ' async defer src', $tag); // OR do both!
}, 10, 2);

add_filter('style_loader_tag', function ($tag, $handle) {
    // if handle contains 'gamipress-', 'bp-', don't add it
    if (str_contains($handle, 'gamipress-') || str_contains($handle, 'bp-')) {
        return '';
    }

    return $tag;
}, 10, 2);

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

/**
 * Add support for features
 */
function yipnyap_support_features(): void
{
    add_theme_support('post-formats', ['video', 'audio', 'gallery']);

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
}

add_action('after_setup_theme', 'yipnyap_support_features');

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
require_once YIPNYAP_PATH . '/includes/api/v2/index.php';

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
    return yipnyap_get_default_member_avatar_url();
}

add_filter('bp_core_default_avatar_user', 'yipnyap_set_default_member_avatar');

/**
 * Set default group avatar
 */
function yipnyap_set_default_group_avatar(): string
{
    return yipnyap_get_default_group_avatar_url();
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

add_filter('bp_core_enable_root_profiles', '__return_true');

/*
 * Now time for the fun stuff. Manipulating buddypress to do
 * what we want. Mwa ha ha ha.
 */

// Dont save activities of types
function yipnyap_dont_save_activity($activity_object): void
{
    $exclude = ['new_avatar', 'updated_profile', 'friendship_created', 'created_group', 'joined_group', 'new_member'];

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

    return [
        'path' => $path,
        'url' => $url,
        'subdir' => $upload['subdir'],
        'basedir' => $base_dir,
        'baseurl' => YIPNYAP_WPOPTIONS['buddypress']['baseurl'],
        'error' => false
    ];
}

add_filter('bp_attachments_cover_image_upload_dir', 'yipnyap_cover_image_upload_dir', 1, 1);

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
