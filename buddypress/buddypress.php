<?php
/**
 * Vikinger Template - BuddyPress Entry Point
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  get_header();

  if (have_posts()) {
    the_post();
    the_content();
  }

  get_footer();

?>