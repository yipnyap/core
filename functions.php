<?php
/**
 * Yipnyap - Functions
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

/**
 * Rename "Keymaster" role
 * Unfortunately, this is hard set by Wordpress, and I cannot change it from the YapSDK.
 * TODO: Replace this with a separate, configurable plugin later.
 */
add_filter('bbp_get_dynamic_roles', 'ntwb_bbpress_custom_role_names');

function ntwb_bbpress_custom_role_names() {
	return array(

		// Keymaster
		bbp_get_keymaster_role() => array(
			'name'         => 'Staff',
			'capabilities' => bbp_get_caps_for_role(bbp_get_keymaster_role())
		),

		// Moderator
		bbp_get_moderator_role() => array(
			'name'         => 'Moderator',
			'capabilities' => bbp_get_caps_for_role(bbp_get_moderator_role())
		),

		// Participant
		bbp_get_participant_role() => array(
			'name'         => 'Participant',
			'capabilities' => bbp_get_caps_for_role(bbp_get_participant_role())
		),

		// Spectator
		bbp_get_spectator_role() => array(
			'name'         => 'Spectator',
			'capabilities' => bbp_get_caps_for_role(bbp_get_spectator_role())
		),

		// Blocked
		bbp_get_blocked_role() => array(
			'name'         => 'Blocked',
			'capabilities' => bbp_get_caps_for_role(bbp_get_blocked_role())
		)
	);
}

/**
 * THEME CONSTANTS
 */

/**
 * Versioning
 */
define('VIKINGER_VERSION', '1.7.0.1');
define('VIKINGER_VERSION_OPTION', 'vikinger_version');

/**
 * Theme paths and urls
 */
define('VIKINGER_PATH', get_template_directory());
define('VIKINGER_URL', get_template_directory_uri());
define('VIKINGER_UPLOADS_PATH', wp_get_upload_dir()['basedir'] . '/vikinger');
define('VIKINGER_UPLOADS_URL', wp_get_upload_dir()['baseurl'] . '/vikinger');

/**
 * TRANSLATION functions
 */
require_once VIKINGER_PATH . '/includes/functions/vikinger-functions-translation.php';

/**
 * Load admin styles and scripts
 */
function vikinger_admin_load_scripts() {
  // load fonts
  wp_enqueue_style('vikinger-admin-fonts', 'https://fonts.googleapis.com/css?family=Rajdhani:400,500,600,700|Titillium+Web:400,900&display=swap');

  // add custom stylesheets
  wp_enqueue_style('vikinger-admin-styles', VIKINGER_URL . '/css/admin-style.min.css', array(), '1.3.1');

  // add custom scripts
  wp_enqueue_script('vikinger-admin-scripts', VIKINGER_URL . '/src/admin.bundle.min.js', [], '3.8.1', true);

  // pass php variables to javascript file
  wp_localize_script('vikinger-admin-scripts', 'vikinger_constants', array(
    'vikinger_admin_ajax_nonce' => wp_create_nonce('vikinger_admin_ajax')
  ));

  // pass translation strings to javascript file
  wp_localize_script('vikinger-admin-scripts', 'vikinger_translation', vikinger_translation_get());
}

add_action('admin_enqueue_scripts', 'vikinger_admin_load_scripts');

/**
 * Load theme styles and scripts
 */
function vikinger_load_scripts() {
  // get fonts
  $fonts = vikinger_customizer_theme_fonts_get_for_enqueue();

  // load fonts
  wp_enqueue_style('vikinger-fonts', 'https://fonts.googleapis.com/css?family=' . $fonts['primary'] . ':400,500,600,700|' . $fonts['secondary'] . ':400,900&display=swap');

  // add custom stylesheets
  wp_enqueue_style('vikinger-simplebar-styles', get_template_directory_uri() . '/css/vendor/simplebar.css', [], '1.0.0');
  wp_enqueue_style('vikinger-swiper-slider-styles', get_template_directory_uri() . '/css/vendor/swiper.min.css', [], '1.0.0');
  wp_enqueue_style('oldkiner-styles', get_template_directory_uri() . '/style.css', ['vikinger-simplebar-styles', 'vikinger-swiper-slider-styles'], '3.8.1');
  wp_enqueue_style('yapex-styles', get_template_directory_uri() . '/src/css/styles.min.css', [], '1.10.0');
  wp_enqueue_style('yapex-shared-styles', get_template_directory_uri() . '/css/yapsdk/ex-shared.css', [], '1.0.2');

  // get user custom theme fonts
  $custom_fonts = vikinger_customizer_theme_fonts_get_style();

  // add user custom theme fonts
  wp_add_inline_style('oldkiner-styles', $custom_fonts);

  // get user custom theme colors
  $custom_colors = vikinger_customizer_theme_colors_get();

  // add user custom theme colors
  wp_add_inline_style('oldkiner-styles', $custom_colors);

  // add plugins
  wp_enqueue_script('vikinger-swiper-scripts', VIKINGER_URL . '/src/js/vendor/swiper.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmaccordion-scripts', VIKINGER_URL . '/src/js/vendor/xm_accordion.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmdropdown-scripts', VIKINGER_URL . '/src/js/vendor/xm_dropdown.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmhexagon-scripts', VIKINGER_URL . '/src/js/vendor/xm_hexagon.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmpopup-scripts', VIKINGER_URL . '/src/js/vendor/xm_popup.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmprogressBar-scripts', VIKINGER_URL . '/src/js/vendor/xm_progressBar.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmtab-scripts', VIKINGER_URL . '/src/js/vendor/xm_tab.min.js', [], '1.0.0', true);
  wp_enqueue_script('vikinger-xmtooltip-scripts', VIKINGER_URL . '/src/js/vendor/xm_tooltip.min.js', [], '1.0.0', true);

  $vikinger_main_scripts_dependencies = [
    'jquery',
    'vikinger-swiper-scripts',
    'vikinger-xmaccordion-scripts',
    'vikinger-xmdropdown-scripts',
    'vikinger-xmhexagon-scripts',
    'vikinger-xmpopup-scripts',
    'vikinger-xmprogressBar-scripts',
    'vikinger-xmtab-scripts',
    'vikinger-xmtooltip-scripts'
  ];

  // add main script
  wp_enqueue_script('vikinger-main-scripts', VIKINGER_URL . '/src/app.bundle.min.js', $vikinger_main_scripts_dependencies, '3.8.1', true);

  // add EX script
  wp_enqueue_script('yapex-main-scripts', VIKINGER_URL . '/src/js/yapsdk/ex.js', ['jquery'], '1.0.3', true);

  global $vikinger_settings;

  $vikinger_settings = vikinger_settings_get();

  // pass php variables to javascript file
  wp_localize_script('vikinger-main-scripts', 'vikinger_constants', [
    'vikinger_url'                => VIKINGER_URL,
    'home_url'                    => esc_url(home_url('/')),
    'ajax_url'                    => home_url('/sdk'),
    'wp_rest_nonce'               => wp_create_nonce('wp_rest'),
    'vikinger_ajax_nonce'         => wp_create_nonce('vikinger_ajax'),
    'rest_root'                   => esc_url_raw(rest_url()),
    'plugin_active'               => vikinger_plugin_get_required_plugins_activation_status(),
    'gamipress_badge_type_exists' => vikinger_plugin_gamipress_is_active() && vikinger_gamipress_achievement_type_exists('badge'),
    'colors'                      => vikinger_customizer_theme_colors_get_array(),
    'settings'                    => $vikinger_settings
  ]);

  // pass translation strings to javascript file
  wp_localize_script('vikinger-main-scripts', 'vikinger_translation', vikinger_translation_get());
}

add_action('wp_enqueue_scripts', 'vikinger_load_scripts');

/**
 * Remove plugin styles that are not needed to reduce file queries
 */
function vikinger_dequeue_styles() {
  // remove BuddyPress styles
  wp_dequeue_style('bp-legacy-css');

  // remove GamiPress styles
  wp_dequeue_style('gamipress-css');
}

add_action('wp_enqueue_scripts', 'vikinger_dequeue_styles', 20);

/**
 * Add body class filters
 */
function vikinger_body_classes($classes){
  if (is_admin_bar_showing()) {
    $classes[] = 'vikinger-top-space';
  }

  if (!is_user_logged_in()) {
    $classes[] = 'vikinger-logged-out';
  }

  return $classes;
}

add_filter('body_class', 'vikinger_body_classes');

/**
 * Theme Options
 */
function vikinger_admin_page_index_html() {
  $filepath = VIKINGER_PATH . '/views/index.php';
  require_once($filepath);
}

function vikinger_admin_page_plugins_html() {
  $filepath = VIKINGER_PATH . '/views/plugins.php';
  require_once($filepath);
}

function vikinger_admin_page_documentation_html() {
  $filepath = VIKINGER_PATH . '/views/documentation.php';
  require_once($filepath);
}

function vikinger_admin_page_faqs_html() {
  $filepath = VIKINGER_PATH . '/views/faqs.php';
  require_once($filepath);
}

function vikinger_admin_page_troubleshooting_html() {
  $filepath = VIKINGER_PATH . '/views/troubleshooting.php';
  require_once($filepath);
}

function vikinger_admin_page_changelog_html() {
  $filepath = VIKINGER_PATH . '/views/changelog.php';
  require_once($filepath);
}

function vikinger_admin_page_support_html() {
  $filepath = VIKINGER_PATH . '/views/support.php';
  require_once($filepath);
}

function vikinger_admin_page_demo_import_html() {
  $filepath = VIKINGER_PATH . '/views/demo-import.php';
  require_once($filepath);
}

function vikinger_admin_page_index() {
  add_menu_page(
    'Vikinger - Index',
    'YapSDK',
    'manage_options',
    'vikinger_index',
    'vikinger_admin_page_index_html',
    VIKINGER_URL . '/img/admin/options-icon.png'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Index',
    'Getting Started',
    'manage_options',
    'vikinger_index',
    'vikinger_admin_page_index_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - General',
    'General',
    'manage_options',
    'vikinger_plugins',
    'vikinger_admin_page_plugins_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Documentation',
    'Documentation',
    'manage_options',
    'vikinger_documentation',
    'vikinger_admin_page_documentation_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - FAQs',
    'FAQs',
    'manage_options',
    'vikinger_faqs',
    'vikinger_admin_page_faqs_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Troubleshooting',
    'Troubleshooting',
    'manage_options',
    'vikinger_troubleshooting',
    'vikinger_admin_page_troubleshooting_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Changelog',
    'Changelog',
    'manage_options',
    'vikinger_changelog',
    'vikinger_admin_page_changelog_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Support',
    'Support',
    'manage_options',
    'vikinger_support',
    'vikinger_admin_page_support_html'
  );

  add_submenu_page(
    'vikinger_index',
    'Vikinger - Demo Import',
    'Demo Import',
    'manage_options',
    'vikinger_demo_import',
    'vikinger_admin_page_demo_import_html'
  );
}

add_action('admin_menu', 'vikinger_admin_page_index');

/**
 * Navigation Menus
 */
function vikinger_register_menus() {
  register_nav_menus(
    array(
      'header_menu'           => esc_html_x('Header Menu', '(Backend) Menu Location Name', 'vikinger'),
      'header_features_menu'  => esc_html_x('Header Features Menu', '(Backend) Menu Location Name', 'vikinger'),
      'side_menu'             => esc_html_x('Side Menu', '(Backend) Menu Location Name', 'vikinger'),
      'footer_menu'           => esc_html_x('Footer Menu', '(Backend) Menu Location Name', 'vikinger')
     )
  );
}

add_action('init', 'vikinger_register_menus');


add_filter('admin_title', 'my_admin_title', 10, 2);
function my_admin_title($admin_title, $title)
{
	// get_bloginfo('name')
   return 'Houndboard &bull; '.$title;
}

/**
 * Add support for features
 */
function vikinger_support_features() {
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
  add_image_size('vikinger-postlist-thumb', 40, 40, true);
  add_image_size('vikinger-postv1-fullscreen', 1980);
  add_image_size('vikinger-postv2-fullscreen', 1184);

  // bbPress images
  add_post_type_support('forum', 'thumbnail');
  add_image_size('vikinger-forum-thumb', 64, 64, true);

  // WooCommerce support
  add_theme_support('woocommerce');
  // WooCommerce gallery support
  add_theme_support('wc-product-gallery-zoom');
  add_theme_support('wc-product-gallery-lightbox');
  add_theme_support('wc-product-gallery-slider');
}

add_action('after_setup_theme', 'vikinger_support_features');

/**
 * Hide admin bar for non administrators
 */
$admin_bar_status = get_theme_mod('vikinger_adminbar_setting_display', 'display');

if (($admin_bar_status === 'hide') && !current_user_can('administrator')) {
  show_admin_bar(false);
}

/**
 * Yipnyap functions
 */
require_once VIKINGER_PATH . '/includes/functions/vikinger-functions.php';

/**
 * Yipnyap filters
 */
require_once VIKINGER_PATH . '/includes/filters/vikinger-filters.php';

/**
 * Yipnyap AJAX
 */
require_once VIKINGER_PATH . '/includes/ajax/vikinger-ajax.php';

/**
 * Yipnyap sidebars
 */
require_once VIKINGER_PATH . '/includes/sidebars/vikinger-sidebars.php';

/**
 * Yipnyap customizer
 */
require_once VIKINGER_PATH . '/includes/customizer/vikinger-customizer.php';

/**
 * PHP Autoloader
 */
function vikinger_class_autoloader($class_name) {
  $base_path = VIKINGER_PATH . '/includes/classes';

  // utils classes
  $utils_path = $base_path . '/utils';
  $utils_classes = ['Vikinger_Scheduler', 'Vikinger_Task'];

  foreach ($utils_classes as $utils_class) {
    if ($class_name === $utils_class) {
      require $utils_path . '/' . $class_name . '.php';
    }
  }
}

spl_autoload_register('vikinger_class_autoloader');

/**
 * Allow the use of wp_redirect / wp_safe_redirect after headers are sent (after the get_header() function is called)
 */
function vikinger_allow_redirect_after_header() {
  ob_start();
}

add_action('init', 'vikinger_allow_redirect_after_header');

/**
 * Custom BuddyPress Avatar Dimensions
 */
define('BP_AVATAR_THUMB_WIDTH', 50);
define('BP_AVATAR_THUMB_HEIGHT', 50);
define('BP_AVATAR_FULL_WIDTH', 100);
define('BP_AVATAR_FULL_HEIGHT', 100);
define('BP_AVATAR_ORIGINAL_MAX_WIDTH', 640);

/**
 * Setup member cover preferred image size
 */
function vikinger_members_cover_image_setup($settings = []) {
  // dimension settings
  $settings['width'] = 1184;
  $settings['height'] = 300;

  return $settings;
}

add_filter('bp_before_members_cover_image_settings_parse_args', 'vikinger_members_cover_image_setup', 10, 1);

/**
 * Setup group cover preferred image size
 */
function vikinger_group_cover_image_setup($settings = []) {
  // dimension settings
  $settings['width'] = 1184;
  $settings['height'] = 300;

  return $settings;
}
add_filter('bp_before_groups_cover_image_settings_parse_args', 'vikinger_group_cover_image_setup', 10, 1);

/**
 * Disable Gravatar
 */
add_filter('bp_core_fetch_avatar_no_grav', '__return_true');

/**
 * Set default member avatar
 */
function vikinger_set_default_member_avatar() {
  $members_default_avatar_url = vikinger_get_default_member_avatar_url();

  return $members_default_avatar_url;
}

add_filter('bp_core_default_avatar_user', 'vikinger_set_default_member_avatar');

/**
 * Set default group avatar
 */
function vikinger_set_default_group_avatar() {
  $groups_default_avatar_url = vikinger_get_default_group_avatar_url();

  return $groups_default_avatar_url;
}

add_filter('bp_core_default_avatar_group', 'vikinger_set_default_group_avatar');

/**
 * Load translations
 */
function vikinger_translations_load() {
  load_theme_textdomain('vikinger', VIKINGER_PATH . '/languages');
}

add_action('after_setup_theme', 'vikinger_translations_load');

add_filter( 'login_title',function($login_title){
	return str_replace(array( ' &lsaquo;', ' &#8212; WordPress',__('WordPress'),), array( ' &lsaquo;', ''),$login_title );
});

add_filter(
    'wp_php_error_message',
    function( $message, $error ) {
		global $wp_filter;
		
		$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$date = date('m/d/Y h:i:s a', time());
//		$new_error = substr($error["message"], 0, 100) . '...';

        return 'A critical error on Houndkit has occurred. Go back.<br><br>Error Type ' . $error["type"] . ' @ ' . $date . ' : ' . $actual_link . '<br><br>current hooks in session: ' . count($wp_filter) . '<br><hr><br>' . $error["message"];
    },
    10,
    2
);

function my_retrieve_password_subject_filter($old_subject) {
  // $old_subject is the default subject line created by WordPress.
  // (You don't have to use it.)

  $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
  $subject = sprintf( __('[%s] Password Reset'), $blogname );
  // This is how WordPress creates the subject line. It looks like this:
  // [Doug's blog] Password Reset
  // You can change this to fit your own needs.

  // You have to return your new subject line:
  return $subject;
}

function my_retrieve_password_message_filter($old_message, $key, $user_login) {
  // $old_message is the default message already created by WordPress.
  // (You don't have to use it.)
  // $key is the password-like token that allows the user to get
  // a new password

  $message = __('Someone has asked to reset the password your Yipnyap ID.') . "\r\n\r\n";
//  $message .= network_site_url() . "\r\n\r\n";
//  $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
  $message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.') . "\r\n\r\n";
  $message .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";

  // This is how WordPress creates the message.
  // You can change this to meet your own needs.

  // You have to return your new message:
  return $message;
}

// To get these filters up and running:
add_filter ( 'retrieve_password_title', 'my_retrieve_password_subject_filter', 10, 1 );
add_filter ( 'retrieve_password_message', 'my_retrieve_password_message_filter', 10, 2 );

?>
