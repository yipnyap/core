<?php
/**
 * Yipnyap Template - BuddyPress Groups Creation
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  if (is_user_logged_in()) {
    $user_domain = bp_core_get_user_domain(get_current_user_id());

    $url = trailingslashit($user_domain . 'settings/manage-groups');

    wp_safe_redirect(trailingslashit($url));
    
    exit;

  } else {
    get_template_part('404');
  }

?>