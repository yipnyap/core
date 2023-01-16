<?php
/**
 * Yipnyap functions
 *
 * @since 1.0.0
 */

/**
 * Allocated Storage functions
 */
require_once YIPNYAP_PATH . '/includes/functions/nextgen/index.php';

/**
 * UTILS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-utils.php';

/**
 * SETTINGS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-settings.php';

/**
 * PLUGIN functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-plugin.php';

/**
 * BLOG functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-blog.php';

/**
 * COMMENT functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-comment.php';

/**
 * USER functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-user.php';

if (yipnyap_plugin_gamipress_is_active()) {
    /**
     * GamiPress
     */
    require_once YIPNYAP_PATH . '/includes/functions/gamipress/functions-gamipress.php';
}

/**
 * BuddyPress
 */
require_once YIPNYAP_PATH . '/includes/functions/buddypress/functions-buddypress.php';

/**
 * VKMedia
 */
require_once YIPNYAP_PATH . '/includes/functions/vkmedia/functions-vkmedia.php';


/**
 * FILE functions
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-file.php';

/**
 * BBPRESS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/bbpress/functions-bbpress.php';

/**
 * BP BETTER MESSAGES functions
 */
require_once YIPNYAP_PATH . '/includes/functions/bpbettermessages/functions-bpbettermessages.php';

/**
 * VERIFIED MEMBER FOR BUDDYPRESS functions
 */
require_once YIPNYAP_PATH . '/includes/functions/bpverifiedmember/functions-bpverifiedmember.php';

/**
 * WOOCOMMERCE functions
 */
//require_once YIPNYAP_PATH . '/includes/functions/woocommerce/functions-woocommerce.php';

/**
 * Paid Memberships Pro
 */
//require_once YIPNYAP_PATH . '/includes/functions/pmpro/functions-pmpro.php';

/**
 * Stream
 */
require_once YIPNYAP_PATH . '/includes/functions/functions-stream.php';
