<?php
/**
 * Yipnyap Template Part - Search Form
 *
 * @param array $args {
 * @type array $attributes List additional attributes.
 * }
 * @since 1.8.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @package Yipnyap
 */

$attributes = isset($args['attributes']) ? $args['attributes'] : [];

$search_form_attributes = [];

$search_form_attributes = array_merge($search_form_attributes, $attributes);

$search_form_attributes_string = '';

foreach ($search_form_attributes as $search_form_attribute => $search_form_attribute_value) {
    $search_form_attributes_string .= ' data-' . $search_form_attribute . '="' . esc_attr($search_form_attribute_value) . '"';
}

?>

<!-- SEARCH FORM -->
<div id="vk-search-form" <?php echo $search_form_attributes_string; ?>></div>
<!-- /SEARCH FORM -->
