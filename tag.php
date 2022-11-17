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
