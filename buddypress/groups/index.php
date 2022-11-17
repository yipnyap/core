<?php
/**
 * Yipnyap Template - BuddyPress Groups Index
 *
 * Displays all the groups of the site
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

?>

<!-- CONTENT GRID -->
<div class="content-grid">
<?php

  bp_get_template_part('groups/groups-loop');

?>
</div>
<!-- /CONTENT GRID -->
