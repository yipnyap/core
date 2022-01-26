<?php
/**
 * Yipnyap Elementor - Utils functions
 * 
 * @since 1.0.0
 */

/**
 * Checks if the current page is an elementor page
 * 
 * @return bool $elementor_page      True if elementor page, false otherwise.
 */
function yipnyap_is_elementor_page(){
  global $post;

  return \Elementor\Plugin::$instance->db->is_built_with_elementor($post->ID);
}

function yipnyap_elementor_styles_encode_get($styles) {
  $output = 'style=';

  foreach ($styles as $key => $value) {
    if ($value !== '') {
      $output .= $key . ':' . $value . ';';
    }
  }

  return $output;
}

?>
