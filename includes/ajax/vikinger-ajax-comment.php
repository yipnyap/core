<?php
/**
 * Yipnyap COMMENT AJAX
 * 
 * @since 1.0.0
 */

/**
 * Creates a new comment
 *
 */
function yipnyap_create_comment_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $comment_data = isset($_POST['comment_data']) ? $_POST['comment_data'] : false;

  if (!$comment_data) {
    wp_die('Missing Parameters');
  }

  $comment_author_id = array_key_exists('user_id', $comment_data) ? (int) $comment_data['user_id'] : false;

  // get logged user id
  $logged_user_id = get_current_user_id();

  $logged_user_is_comment_author = $logged_user_id === $comment_author_id;

  if (!$logged_user_is_comment_author) {
    wp_die('Unauthorized');
  }

  // comment ID on success, false on error
  $result = yipnyap_create_comment($comment_data);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_create_comment_ajax', 'yipnyap_create_comment_ajax');

/**
 * Update post comment
 */
function yipnyap_comment_update_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $args = isset($_POST['args']) ? $_POST['args'] : false;

  if (!$args) {
    wp_die('Missing Parameters');
  }

  $comment_id = array_key_exists('comment_ID', $args) ? (int) $args['comment_ID'] : false;

  if (!$comment_id) {
    wp_die('Missing Parameters');
  }

  $logged_user_is_site_admin = current_user_can('administrator');

  // get logged user id
  $logged_user_id = get_current_user_id();

  $wp_comment_args = [
    'comment__in'  => [$comment_id]
  ];
  $wp_comment = get_comments($wp_comment_args);

  if (count($wp_comment) === 0) {
    wp_die('Comment not found');
  }

  $comment = $wp_comment[0];

  $comment_author_id = (int) $comment->user_id;

  $logged_user_is_comment_author = $logged_user_id === $comment_author_id;

  if (!$logged_user_is_site_admin && !$logged_user_is_comment_author) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_comment_update($args);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_comment_update_ajax', 'yipnyap_comment_update_ajax');

/**
 * Delete post comment
 */
function yipnyap_post_comment_delete_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $args = isset($_POST['args']) ? $_POST['args'] : false;

  if (!$args) {
    wp_die('Missing Parameters');
  }

  $comment_id = array_key_exists('comment_id', $args) ? (int) $args['comment_id'] : false;

  if (!$comment_id) {
    wp_die('Missing Parameters');
  }

  $logged_user_is_site_admin = current_user_can('administrator');

  // get logged user id
  $logged_user_id = get_current_user_id();

  $wp_comment_args = [
    'comment__in'  => [$comment_id]
  ];
  $wp_comment = get_comments($wp_comment_args);

  if (count($wp_comment) === 0) {
    wp_die('Comment not found');
  }

  $comment = $wp_comment[0];

  $comment_author_id = (int) $comment->user_id;

  $logged_user_is_comment_author = $logged_user_id === $comment_author_id;

  if (!$logged_user_is_site_admin && !$logged_user_is_comment_author) {
    wp_die('Unauthorized');
  }

  $result = yipnyap_post_comment_delete($comment_id);

  header('Content-Type: application/json');
  echo json_encode($result);

  wp_die();
}

add_action('wp_ajax_yipnyap_post_comment_delete_ajax', 'yipnyap_post_comment_delete_ajax');

/**
 * Get filtered comments with children
 */
function yipnyap_get_comments_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');

  $args = isset($_POST['args']) ? $_POST['args'] : [];

  $comments = yipnyap_get_comments($args);

  header('Content-Type: application/json');
  echo json_encode($comments);

  wp_die();
}

add_action('wp_ajax_yipnyap_get_comments_ajax', 'yipnyap_get_comments_ajax');
add_action('wp_ajax_nopriv_yipnyap_get_comments_ajax', 'yipnyap_get_comments_ajax');

/**
 * Get a post top level comments count (comments with no parent)
 */
function yipnyap_get_post_top_level_comment_count_ajax() {
  // nonce check, dies early if the nonce cannot be verified
  check_ajax_referer('yipnyap_ajax');
  
  // get comment count for postID
  $comment_count = yipnyap_get_post_top_level_comment_count($_POST['postID']);

  header('Content-Type: application/json');
  
  // return comment count
  echo json_encode($comment_count);

  wp_die();
}

add_action('wp_ajax_yipnyap_get_post_top_level_comment_count_ajax', 'yipnyap_get_post_top_level_comment_count_ajax');
add_action('wp_ajax_nopriv_yipnyap_get_post_top_level_comment_count_ajax', 'yipnyap_get_post_top_level_comment_count_ajax');

?>
