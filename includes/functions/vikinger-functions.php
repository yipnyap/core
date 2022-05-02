<?php
/**
 * Yipnyap functions
 *
 * @since 1.0.0
 */

/**
 * UTILS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-utils.php';

/**
 * DEMO functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-demo.php';

/**
 * SETTINGS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-settings.php';

/**
 * PLUGIN functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-plugin.php';

/**
 * WPLOGIN functions
 */
//require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-wplogin.php';

/**
 * REGISTER functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-register.php';

/**
 * BLOG functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-blog.php';

/**
 * COMMENT functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-comment.php';

/**
 * USER functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-user.php';

if (yipnyap_plugin_gamipress_is_active()) {
    /**
     * GamiPress
     */
    require_once YIPNYAP_PATH . '/includes/functions/gamipress/vikinger-functions-gamipress.php';
}

/**
 * BuddyPress
 */
require_once YIPNYAP_PATH . '/includes/functions/buddypress/functions-buddypress.php';

/**
 * FILE functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-file.php';

/**
 * BBPRESS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-bbpress.php';

/**
 * BP BETTER MESSAGES functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-bpbettermessages.php';

/**
 * VERIFIED MEMBER FOR BUDDYPRESS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-bpverifiedmember.php';

/**
 * WOOCOMMERCE functions
 */
require_once YIPNYAP_PATH . '/includes/functions/vikinger-functions-woocommerce.php';

/**
 * Paid Memberships Pro
 */
require_once YIPNYAP_PATH . '/includes/functions/pmpro/vikinger-functions-pmpro.php';

?>
