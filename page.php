<?php
/**
 * Yipnyap Template - Page
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.me/)
 *
 */

get_header();

if (have_posts()) {
    the_post();

    // not an Elementor or bbPress page, load regular page template
    $post_data = yipnyap_page_get_loop_data();

    /**
     * Page Open
     */
    get_template_part('template-part/page/page-open', null, [
        'post' => $post_data
    ]);
}

get_footer();
