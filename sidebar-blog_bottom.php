<?php
/**
 * Vikinger Sidebar - Sidebar Blog Bottom
 * 
 * Horizontal sidebar that appears below the blog post
 * 
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

  if (is_active_sidebar('blog_bottom')) {
    dynamic_sidebar('blog_bottom');
  }

?>