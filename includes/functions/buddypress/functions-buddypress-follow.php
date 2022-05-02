<?php
/**
 * Yipnyap FOLLOW functions
 * 
 * @since 1.0.0
 */

if (!function_exists('yipnyap_follow_add')) {
  /**
   * Sends a friend request (or adds a friend if $force_accept is true)
   * 
   * @param array $args
   * @param int     $follower_id            ID of the user that initiated the friend request
   * @param int     $leader_id              ID of the user to become friends with
   * @return boolean
   */
  function yipnyap_follow_add($args) {
    return bp_follow_start_following($args);
  }
}

if (!function_exists('yipnyap_follow_remove')) {
  /**
   * Sends a friend request (or adds a friend if $force_accept is true)
   * 
   * @param array $args
   * @param int     $follower_id            ID of the user that initiated the friend request
   * @param int     $leader_id              ID of the user to become friends with
   * @return boolean
   */
  function yipnyap_follow_remove($args) {
    return bp_follow_stop_following($args);
  }
}
?>
