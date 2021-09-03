<?php
/**
 * Yipnyap Template - BuddyPress Groups Loop
 * 
 * Displays the groups loop
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  $groups_grid_type = vikinger_logged_user_grid_type_get('group');

?>

<!-- GROUP FILTERABLE LIST -->
<div id="group-filterable-list" class="filterable-list" data-grid-type="<?php echo esc_attr($groups_grid_type); ?>"></div>
<!-- /GROUP FILTERABLE LIST -->