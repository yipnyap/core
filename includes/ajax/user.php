<?php
/**
 * Yipnyap USER AJAX
 * 
 * @since 1.0.0
 */

/**
 * Get logged in user member data, or false if no user is logged in
 */
function yipnyap_get_logged_user_member_data_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');
  
  $data_scope = $_POST['data_scope'] ?? 'user-status';

  $user = yipnyap_get_logged_user_member_data($data_scope);

  header('Content-Type: application/json');
  echo json_encode($user);

  wp_die();
}

add_action('wp_ajax_yipnyap_get_logged_user_member_data_ajax', 'yipnyap_get_logged_user_member_data_ajax');
add_action('wp_ajax_nopriv_yipnyap_get_logged_user_member_data_ajax', 'yipnyap_get_logged_user_member_data_ajax');

/**
 * Toggle logged user color theme
 */
function yipnyap_logged_user_color_theme_toggle_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');
  
  $result = yipnyap_logged_user_color_theme_toggle();

  header('Content-Type: application/json');
  
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_logged_user_color_theme_toggle_ajax', 'yipnyap_logged_user_color_theme_toggle_ajax');

/**
 * Update logged user posts grid type
 */
function yipnyap_logged_user_grid_type_update_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');
  
  $result = yipnyap_logged_user_grid_type_update($_POST['args']['grid_component'], $_POST['args']['grid_type']);

  header('Content-Type: application/json');
  
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_logged_user_grid_type_update_ajax', 'yipnyap_logged_user_grid_type_update_ajax');

/**
 * Update logged user sidemenu status
 */
function yipnyap_logged_user_sidemenu_status_update_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');
  
  $result = yipnyap_logged_user_sidemenu_status_update($_POST['args']['sidemenu_status']);

  header('Content-Type: application/json');
  
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_logged_user_sidemenu_status_update_ajax', 'yipnyap_logged_user_sidemenu_status_update_ajax');
add_action('wp_ajax_nopriv_yipnyap_logged_user_sidemenu_status_update_ajax', 'yipnyap_logged_user_sidemenu_status_update_ajax');

/**
 * Get logged user stream username
 */
function yipnyap_logged_user_stream_username_get_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $result = yipnyap_logged_user_stream_username_get();

  header('Content-Type: application/json');

  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_logged_user_stream_username_get_ajax', 'yipnyap_logged_user_stream_username_get_ajax');

/**
 * Update logged user stream username
 */
function yipnyap_logged_user_stream_username_update_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $result = yipnyap_logged_user_stream_username_update($_POST['args']['username']);

  header('Content-Type: application/json');

  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_logged_user_stream_username_update_ajax', 'yipnyap_logged_user_stream_username_update_ajax');
