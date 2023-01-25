<?php
/**
 * Yipnyap Sidebar - Sidebar Blog
 * 
 * Vertical sidebar on the right or left side of the blog post
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  if (is_active_sidebar('blog')) {
    dynamic_sidebar('blog');
  }
  
?>