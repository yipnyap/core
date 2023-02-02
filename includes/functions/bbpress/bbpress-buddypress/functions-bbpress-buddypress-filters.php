<?php
/**
 * Functions - bbPress + BuddyPress - Filters
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

if (!function_exists('yipnyap_bbpress_format_activity_action_new_topic')) {
  /**
   * Action string format for the bbp_topic_create action
   * 
   * @param string $action    Action string
   * @param Object $activity  Activity item object
   * @return string
   */
  function yipnyap_bbpress_format_activity_action_new_topic($action, $activity) {
    $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

    // remove first anchor, which contains user fullname
    return preg_replace($pattern, '', $action, 1);
  }
}

add_filter('bbp_format_activity_action_new_topic', 'yipnyap_bbpress_format_activity_action_new_topic', 10, 2);

if (!function_exists('yipnyap_bbpress_format_activity_action_new_reply')) {
  /**
   * Action string format for the bbp_reply_create action
   * 
   * @param string $action    Action string
   * @param Object $activity  Activity item object
   * @return string
   */
  function yipnyap_bbpress_format_activity_action_new_reply($action, $activity) {
    $pattern = '/<\s*a[^>]*>[^<]*<\s*\/a\s*>\s*/';

    // remove first anchor, which contains user fullname
    return preg_replace($pattern, '', $action, 1);
  }
}

add_filter('bbp_format_activity_action_new_reply', 'yipnyap_bbpress_format_activity_action_new_reply', 10, 2);

?>
