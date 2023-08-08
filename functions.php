<?php
/**
 * Yipnyap - Functions
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

// Check if composer is installed
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo '<h1>read the docs next time</h1>';
    echo '<p>Yipnyap is babysitting you.</p>';
    echo '<p>Run <code>composer install</code> in the theme directory. For more information, visit <a href="https://getcomposer.org/">https://getcomposer.org/</a></p>';
    exit();
}

require_once __DIR__ . '/vendor/autoload.php';
use Firebase\JWT\JWT;

// Dumb stupid requires
require_once __DIR__ . '/global/nextgen2/debug.php';
require_once __DIR__ . '/includes/utils/monolog.php';
require_once __DIR__ . '/wp-beheadding/index.php';

define('YIPNYAP_PATH', get_template_directory());
define('YIPNYAP_URL', get_template_directory_uri());
define('YIPNYAP_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/yipnyap');
define('YIPNYAP_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/yipnyap');

// Check the current 'Authorization' header
// If it's set, then get the current user and set it on WordPress
add_action('determine_current_user', function() {
    $headers = getallheaders();
    $auth = $headers['Authorization'] ?? $headers['authorization'] ?? null;

    if ($auth) {
        $token = str_replace('Bearer ', '', $auth);
        $serviceKey = YIPNYAP_SUPABASE_SERVICE_KEY;
        $decoded = @JWT::decode($token, $serviceKey, ['HS256']);
        if (empty($decoded)) {
            wp_send_json([
                'success' => false,
                'message' => 'Invalid token.',
            ]);

            return null;
        } else {
            $user = get_user_by('id', $decoded->data->id);
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);

            return $user->ID;
        }
    }

    return null;
});

//add_action('init', function () {
    $wizard_status = YIPNYAP_WIZARD_STATUS;
    if (empty($wizard_status) || $wizard_status !== 'DONE' || !file_exists(YIPNYAP_ENV_PATH)) {
        // If admin page or an admin user (to setup), dont do anything
        if (current_user_can('administrator') || str_contains($_SERVER['SERVER_NAME'], 'local')) {
            if (!is_admin()) {
                get_template_part('plugins/wizard/initial');
                exit();
            } else {
                // show admin notice
                add_action('admin_notices', function () {
                    echo '<div class="notice notice-warning is-dismissible">
                        <p>Yipnyap needs to complete installation. Go to your site\'s homepage.</p>
                    </div>';
                });
            }
        } else {
            get_template_part('plugins/maintenance/page', null, [
                'message' => 'Yipnyap is updating, please come back in a few minutes!',
            ]);
            exit();
        }
    }
//}, 30);

// Load plugins bundled with theme
require_once __DIR__ . '/plugins/plugins.php';

/**
 * THEME CONSTANTS
 */
define("YIPNYAP_IS_LOCAL_DEV", empty(YIPNYAP_SETUP_AS_PRODUCTION) || YIPNYAP_SETUP_AS_PRODUCTION !== 'true');

/**
 * Versioning
 */
try {
    define('YIPNYAP_DEVELOPER_VERSION', bin2hex(random_bytes(8)));
} catch (Exception $e) {
    define('YIPNYAP_DEVELOPER_VERSION', 'dev/unknown');
}

const YIPNYAP_VERSION = 'core2';
const YIPNYAP_UI_VERSION = 'ui3-EarlyR';
const YIPNYAP_API_VERSION = 'v2';

// If the request isnt for /wp-admin, or /wp-login.php, then redirect to /api
if (!str_contains($_SERVER['REQUEST_URI'], '/wp-admin') && !str_contains($_SERVER['REQUEST_URI'], '/wp-login.php') && !str_contains($_SERVER['REQUEST_URI'], '/api')) {
    add_action('init', function () {
        if (!str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
            wp_redirect('/api');
            exit();
        }
    }, 1);
}

if ($_SERVER['REQUEST_URI'] === '/api' || $_SERVER['REQUEST_URI'] === '/api/') {
    /**
     * Do health check
     */
    $status = '';
    $components = [];

    function pingTest($url, $component): void
    {
        global $status, $components;

        // Replace HTTP(S) with TCP
        $url = str_replace('https', 'tcp', $url);
        $url = str_replace('http', 'tcp', $url);

        $starttime = microtime(true);
        $file = @fsockopen($url, 80, $errno, $errstr, 10);
        $stoptime = microtime(true);

        if (!$file) $ping = -1;  // Site is down
        else {
            fclose($file);
            $ping = ($stoptime - $starttime) * 1000;
            $ping = floor($ping);
        }

        if ($ping >= 0 && $ping < 1000) {
            $status = 'ok';
            $components[$component] = [
                'status' => 'ok',
            ];
        } elseif ($ping >= 1000 && $ping < 2000) {
            $status = 'unstable';
            $components[$component] = [
                'status' => 'unstable',
            ];
        } else {
            $status = 'down';
            $components[$component] = [
                'status' => 'down',
            ];
        }

        $components[$component]['avg_ping'] = $ping;
    }

    pingTest(YIPNYAP_SUPABASE_URL, 'supabase');
    pingTest(get_option('siteurl'), 'wordpress');

    wp_send_json([
        'ui_version' => YIPNYAP_UI_VERSION,
        'api_version' => YIPNYAP_API_VERSION,
        'version' => YIPNYAP_VERSION,
        'health' => [
            'status' => $status,
            'components' => $components,
        ],
    ]);
}

/**
 * Change Wordpress Settings
 */
const YIPNYAP_WPOPTIONS = [
    'blogname' => 'Yipnyap',
    'blogdescription' => 'A furry safespace',
    'buddypress' => [
        'basedir' => WP_CONTENT_DIR . '/uploads',
        'baseurl' => WP_CONTENT_URL . '/uploads',
    ]
];

foreach (get_object_vars((object) YIPNYAP_WPOPTIONS) as $key => $option) {
    $change_required = get_option($key) !== $option;
//    echo $key . ': ' . $option . ' | current: ' . get_option($key) . ' | change required: ' . $change_required . '<br>';
    if ($change_required && ($option !== 'DEVTEST' || $key !== 'yipnyap_logo_url')) {
        update_option($key, $option);
    }
}

/**
 * Disables BuddyPress' registration process and fallsback to WordPress' one.
 */
function yipnyap_disable_bp_registration(): void {
    remove_action('bp_init', 'bp_core_wpsignup_redirect');
    remove_action('bp_screens', 'bp_core_screen_signup');
}

add_action('bp_loaded', 'yipnyap_disable_bp_registration');

/**
 * Redirect to login after reset password
 */
add_action('login_headerurl', function () {
    // Check if have submitted
    $confirm = (isset($_GET['action']) && $_GET['action'] == 'resetpass');

    if ($confirm) {
        wp_redirect('/id/login/');
        exit;
    }
});

/**
 * TRANSLATION functions
 */
//require_once YIPNYAP_PATH . '/includes/functions/functions-translation.php';

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
//require_once YIPNYAP_PATH . '/includes/ajax/ajax.php';
require_once YIPNYAP_PATH . '/includes/api/v2/index.php';

/**
 * Yipnyap sidebars
 */
//require_once YIPNYAP_PATH . '/includes/sidebars/sidebars.php';

/**
 * Yipnyap customizer
 */
//require_once YIPNYAP_PATH . '/includes/customizer/customizer.php';

/**
 * PHP Autoloader
 */
function yipnyap_class_autoloader($class_name): void {
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
function yipnyap_allow_redirect_after_header(): void {
    ob_start();
}

add_action('init', 'yipnyap_allow_redirect_after_header');

/**
 * Setup member cover preferred image size
 */
function yipnyap_cover_image_setup($settings = []) {
    // dimension settings
    $settings['width'] = 1500;
    $settings['height'] = 500;

    return $settings;
}

add_filter('bp_before_members_cover_image_settings_parse_args', 'yipnyap_cover_image_setup');
add_filter('bp_before_groups_cover_image_settings_parse_args', 'yipnyap_cover_image_setup');

/**
 * Disable Gravatar
 */
add_filter('bp_core_fetch_avatar_no_grav', '__return_true');

/**
 * Set default group avatar
 */
function yipnyap_set_default_group_avatar(): string {
    return yipnyap_get_default_group_avatar_url();
}

add_filter('bp_core_default_avatar_group', 'yipnyap_set_default_group_avatar');

/**
 * Load translations
 */
function yipnyap_translations_load(): void {
    load_theme_textdomain('yipnyap', YIPNYAP_PATH . '/languages');
}

add_action('after_setup_theme', 'yipnyap_translations_load');

function my_retrieve_password_subject_filter($old_subject): string {
    // $old_subject is the default subject line created by WordPress.
    // (You don't have to use it.)

    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    // This is how WordPress creates the subject line. It looks like this:
    // [Doug's blog] Password Reset
    // You can change this to fit your own needs.

    // You have to return your new subject line:
    return sprintf(__('[%s] Password Reset'), $blogname);
}

function my_retrieve_password_message_filter($old_message, $key, $user_login): string {
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
add_filter('retrieve_password_title', 'my_retrieve_password_subject_filter');
add_filter('retrieve_password_message', 'my_retrieve_password_message_filter', 10, 3);

add_filter('bp_core_enable_root_profiles', '__return_true');

/*
 * Now time for the fun stuff. Manipulating buddypress to do
 * what we want. Mwa ha ha ha.
 */

// Dont save activities of types
function yipnyap_dont_save_activity($activity_object): void {
    $exclude = ['new_avatar', 'updated_profile', 'friendship_created', 'created_group', 'joined_group', 'new_member'];

    if (in_array($activity_object->type, $exclude)) {
        $activity_object->type = false;
    }

}

add_action('bp_activity_before_save', 'yipnyap_dont_save_activity', 1);

// Change the cover upload directory to our custom one
function yipnyap_cover_image_upload_dir($upload): array {
    $base_dir = YIPNYAP_WPOPTIONS['buddypress']['basedir'] . '/';
    $path = $base_dir . $upload['subdir'];
    $url = YIPNYAP_WPOPTIONS['buddypress']['baseurl'] . $upload['subdir'];

    return [
        'path' => $path,
        'url' => $url,
        'subdir' => $upload['subdir'],
        'basedir' => $base_dir,
        'baseurl' => YIPNYAP_WPOPTIONS['buddypress']['baseurl'],
        'error' => false,
    ];
}

add_filter('bp_attachments_cover_image_upload_dir', 'yipnyap_cover_image_upload_dir', 1);

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
