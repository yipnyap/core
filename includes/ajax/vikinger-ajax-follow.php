<?php
/**
 * Yipnyap FOLLOW AJAX
 * 
 * @since 1.0.0
 */

/**
 * Add a follow
 */
function vikinger_follow_add_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('vikinger_ajax');

  $args = isset($_POST['args']) ? $_POST['args'] : false;

  if (!$args) {
    wp_die('Missing Parameters');
  }

  $follower_id = array_key_exists('follower_id', $args) ? (int) $args['follower_id'] : false;
  $leader_id = array_key_exists('leader_id', $args) ? (int) $args['leader_id'] : false;

  if (!$follower_id || !$leader_id) {
    wp_die('Missing Parameters');
  }

  // get logged user id
  $logged_user_id = get_current_user_id();

  // this ensures that the logged in user matches the user creating the follow request
  $logged_user_is_follower_id = $logged_user_id === $follower_id;

  if (!$logged_user_is_follower_id) {
    wp_die('Unauthorized');
  }

  $result = vikinger_follow_add($args);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_vikinger_follow_add_ajax', 'vikinger_follow_add_ajax');

/**
 * Remove a follow
 */
function vikinger_follow_remove_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('vikinger_ajax');

  $args = isset($_POST['args']) ? $_POST['args'] : false;

  if (!$args) {
    wp_die('Missing Parameters');
  }

  $follower_id = array_key_exists('follower_id', $args) ? (int) $args['follower_id'] : false;
  $leader_id = array_key_exists('leader_id', $args) ? (int) $args['leader_id'] : false;

  if (!$follower_id || !$leader_id) {
    wp_die('Missing Parameters');
  }

  // get logged user id
  $logged_user_id = get_current_user_id();

  // this ensures that the logged in user matches the user creating the follow request
  $logged_user_is_follower_id = $logged_user_id === $follower_id;

  if (!$logged_user_is_follower_id) {
    wp_die('Unauthorized');
  }

  $result = vikinger_follow_remove($args);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_vikinger_follow_remove_ajax', 'vikinger_follow_remove_ajax');

?>