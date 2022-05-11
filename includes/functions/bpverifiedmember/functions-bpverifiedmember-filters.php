<?php
/**
 * Functions - BP Verified Member - Filters
 * 
 * @package Yipnyap
 * 
 * @since 2022.05.2
 * 
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

if (!function_exists('yipnyap_comment_author_filter')) {
  /**
   * Undo HTML entities encoding so that verified badge span is not escaped
   */
  function yipnyap_comment_author_filter($author, $comment_id) {
    return wp_specialchars_decode($author, ENT_QUOTES);
  }
}

add_filter('comment_author', 'yipnyap_comment_author_filter', 10, 2);

?>
