<?php
/**
 * Yipnyap AJAX
 *
 * @since 1.0.0
 */

/**
 * USER AJAX
 */
require_once YIPNYAP_PATH . '/includes/ajax/user.php';

/**
 * BLOG AJAX
 */
require_once YIPNYAP_PATH . '/includes/ajax/blog.php';

/**
 * COMMENT AJAX
 */
require_once YIPNYAP_PATH . '/includes/ajax/comment.php';

/**
 * Load BuddyPress related AJAX endpoints only
 * when the plugin is installed and active
 */
if (yipnyap_plugin_buddypress_is_active()) {
  /**
   * MEMBER AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/member.php';

  /**
   * ACTIVITY AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/activity.php';

  /**
   * GROUP AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/group.php';

  /**
   * FRIEND AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/friend.php';

  /**
   * NOTIFICATION AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/notification.php';

  /**
   * MESSAGE AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/message.php';

  /**
   * FOLLOW AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/follow.php';
}

/**
 * Load bbPress related AJAX endpoints only
 * when the plugin is installed and active
 */
if (yipnyap_plugin_bbpress_is_active()) {
  /**
   * BBPRESS AJAX
   */
  require_once YIPNYAP_PATH . '/includes/ajax/bbpress.php';
}
