<?php
/**
 * Yipnyap BLOG filters
 * 
 * @since 1.0.0
 */

/**
 * Filter excerpt 'more' text
 */
function yipnyap_excerpt_more($more) {
  return '...';
}

add_filter('excerpt_more', 'yipnyap_excerpt_more');
