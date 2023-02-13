<?php
/**
 * Yipnyap Template Part - Loader Spinner
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @param array $args {
 *   @type string  $modifiers   Optional. Additional class names to add to the HTML wrapper.
 * }
 */

  $modifiers  = isset($args['modifiers']) ? $args['modifiers'] : false;

  $modifiers_classes  = $modifiers ? $modifiers : '';

?>

<!-- LOADER SPINNER WRAP -->
<span class="loader-spinner-wrap <?php echo esc_attr($modifiers_classes); ?>">
  <!-- LOADER SPINNER -->
  <span class="loader-spinner"></span>
  <!-- /LOADER SPINNER -->
</span>
<!-- /LOADER SPINNER WRAP -->