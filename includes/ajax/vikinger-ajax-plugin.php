<?php
/**
 * Yipnyap PLUGIN AJAX
 * 
 * @since 1.0.0
 */

/**
 * Returns required plugins status. 
 */
function yipnyap_plugin_get_required_plugins_status_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_get_required_plugins_status();

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_get_required_plugins_status_ajax', 'yipnyap_plugin_get_required_plugins_status_ajax');

/**
 * Install and activate plugin.
 */
function yipnyap_plugin_install_and_activate_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }
  
  $result = yipnyap_plugin_install_and_activate($_POST['plugin_name']);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_install_and_activate_ajax', 'yipnyap_plugin_install_and_activate_ajax');

/**
 * Update and activate plugin.
 */
function yipnyap_plugin_update_and_activate_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_update_and_activate($_POST['plugin_name']);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_update_and_activate_ajax', 'yipnyap_plugin_update_and_activate_ajax');

/**
 * Activate a plugin.
 */
function yipnyap_plugin_activate_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_activate($_POST['plugin_slug']);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_activate_ajax', 'yipnyap_plugin_activate_ajax');

/**
 * Get selected plugin preset.
 */
function yipnyap_plugin_selected_preset_get_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_selected_preset_get();

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_selected_preset_get_ajax', 'yipnyap_plugin_selected_preset_get_ajax');

/**
 * Save selected plugin preset.
 */
function yipnyap_plugin_selected_preset_save_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_selected_preset_save($_POST['preset']);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_selected_preset_save_ajax', 'yipnyap_plugin_selected_preset_save_ajax');

/**
 * Get custom preset plugins.
 */
function yipnyap_plugin_custom_preset_plugins_get_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_custom_preset_plugins_get();

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_custom_preset_plugins_get_ajax', 'yipnyap_plugin_custom_preset_plugins_get_ajax');

/**
 * Save custom preset plugins.
 */
function yipnyap_plugin_custom_preset_plugins_save_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_admin_ajax');

  $logged_user_is_site_admin = current_user_can('administrator');

  if (!$logged_user_is_site_admin) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_plugin_custom_preset_plugins_save($_POST['plugins']);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_plugin_custom_preset_plugins_save_ajax', 'yipnyap_plugin_custom_preset_plugins_save_ajax');

?>
