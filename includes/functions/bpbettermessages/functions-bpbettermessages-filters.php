<?php
/**
 * Functions - BP Better Messages - Filters
 * 
 * @package Yipnyap
 * 
 * @since 2022.05.2
 * 
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

if (!function_exists('yipnyap_bp_better_messages_location_overwrite')) {
  /**
   * Replace plugin URL with Yipnyap URL
   */
  function yipnyap_bp_better_messages_location_overwrite($url, $user_id) {
    return bp_core_get_user_domain($user_id) . 'settings/messages/';
  }
}

add_filter('bp_better_messages_page', 'yipnyap_bp_better_messages_location_overwrite', 10, 2);

?>
