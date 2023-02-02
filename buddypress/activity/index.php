<?php

/**
 * Yipnyap Template - BuddyPress Activity Index
 *
 * Displays activity feed (all members activities)
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

$user = is_user_logged_in();
?>

<?php if (!$user) { ?>
    <div id="cmui-landing-activity-header"></div>
<?php } ?>

<!-- CONTENT GRID -->
<div id="ng2-activity"></div>
<!-- /CONTENT GRID -->
