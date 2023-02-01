<?php
/**
 * Yipnyap Template - BuddyPress Members Loop
 *
 * Displays the members loop
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

  $members_grid_type = yipnyap_logged_user_grid_type_get('member');

?>

<!-- MEMBER FILTERABLE LIST -->
<div id="member-filterable-list" class="filterable-list" data-grid-type="<?php echo esc_attr($members_grid_type); ?>"></div>
<!-- /MEMBER FILTERABLE LIST -->
