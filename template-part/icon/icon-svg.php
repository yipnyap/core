<?php
/**
 * Yipnyap Template Part - Icon SVG
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 * @param array $args {
 *   @type string $icon         Icon name.
 *   @type string $modifiers    Optional. Additional class names to add to the HTML wrapper.
 * }
 */

  $modifiers = isset($args['modifiers']) ? $args['modifiers'] : false;

  $modifiers_classes = $modifiers ? $modifiers : '';

?>

<!-- ICON SVG -->
<svg class="icon-<?php echo esc_attr($args['icon']); ?> <?php echo esc_attr($modifiers_classes); ?>">
  <use href="#svg-<?php echo esc_attr($args['icon']); ?>"></use>
</svg>
<!-- ICON SVG -->
