<?php
/**
 * Yipnyap Template - Tag
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

get_header();

$tag = get_queried_object();

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <?php

    $page_header_status = get_theme_mod('yipnyap_pageheader_setting_display', 'display');

    if ($page_header_status === 'display') {
        $blog_header_icon_id = get_theme_mod('yipnyap_pageheader_blog_setting_image', false);
        $blog_header_title = get_theme_mod('yipnyap_pageheader_blog_setting_title', esc_html_x('Blog Posts', 'Blog Page - Title', 'yipnyap'));
        $blog_header_description = get_theme_mod('yipnyap_pageheader_blog_setting_description', esc_html_x('Read about news, announcements and more!', 'Blog Page - Description', 'yipnyap'));

        if ($blog_header_icon_id) {
            $blog_header_icon_url = wp_get_attachment_image_src($blog_header_icon_id, 'full')[0];
        } else {
            $blog_header_icon_url = yipnyap_customizer_blog_page_image_get_default();
        }

        /**
         * Section Banner
         */
        get_template_part('template-part/section/section', 'banner', [
            'section_icon_url' => $blog_header_icon_url,
            'section_title' => $blog_header_title,
            'section_description' => $blog_header_description
        ]);
    }

    /**
     * Section Header
     */
    get_template_part('template-part/section/section', 'header', [
        'section_pretitle' => esc_html__('Search Results', 'yipnyap'),
        'section_title' => esc_html(_n('Tag:', 'Tags:', 1, 'yipnyap')),
        'section_text' => $tag->name
    ]);

    /**
     * Post Filterable List
     */
    get_template_part('template-part/post/post-filterable-list', null, [
        'attributes' => [
            'tag' => $tag->term_id
        ]
    ]);

    ?>
</div>
<!-- /CONTENT GRID -->

<?php get_footer(); ?>
