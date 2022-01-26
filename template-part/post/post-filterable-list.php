<?php
/**
 * Yipnyap Template Part - Post Filterable List
 *
 * @param array $args {
 * @type array $attributes List additional attributes.
 * @type bool $allow_post_types If true, allow post types in filterable list.
 * @type string $post_types Post types to display.
 * }
 * @since 1.7.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_post_get_loop_data
 *
 * @package Yipnyap
 */

$attributes = isset($args['attributes']) ? $args['attributes'] : [];
$post_list_allow_post_types = isset($args['allow_post_types']) ? $args['allow_post_types'] : false;
$post_types = isset($args['post_types']) ? $args['post_types'] : ['post'];

$posts_grid_type = yipnyap_logged_user_grid_type_get('post');

$post_list_attributes = [
    'grid-type' => $posts_grid_type
];
$post_list_attributes = array_merge($post_list_attributes, $attributes);

$post_list_attributes_string = '';

foreach ($post_list_attributes as $post_list_attribute => $post_list_attribute_value) {
    $post_list_attributes_string .= ' data-' . $post_list_attribute . '="' . esc_attr($post_list_attribute_value) . '"';
}

if ($post_list_allow_post_types) {
    $post_type_split_is_enabled = yipnyap_blog_post_type_split_display_is_enabled();

    if ($post_type_split_is_enabled && (count($post_types) > 1)) {
        foreach ($post_types as $post_type) {
            /**
             * Section Header
             */
            get_template_part('template-part/section/section', 'header', [
                'section_pretitle' => esc_html__('Browse', 'yipnyap'),
                'section_title' => ucfirst($post_type)
            ]);
            ?>
            <!-- POST PREVIEW FILTERABLE LIST -->
            <div class="post-preview-filterable-list filterable-list" <?php echo $post_list_attributes_string; ?>
                 data-posttypes="<?php echo esc_attr($post_type); ?>"></div>
            <!-- /POST PREVIEW FILTERABLE LIST -->
            <?php

        }
    } else {

        ?>
        <!-- POST PREVIEW FILTERABLE LIST -->
        <div class="post-preview-filterable-list filterable-list" <?php echo $post_list_attributes_string; ?>
             data-posttypes="<?php echo esc_attr(implode(',', $post_types)); ?>"></div>
        <!-- /POST PREVIEW FILTERABLE LIST -->
        <?php

    }
} else {

    ?>
    <!-- POST PREVIEW FILTERABLE LIST -->
    <div class="post-preview-filterable-list filterable-list" <?php echo $post_list_attributes_string; ?>></div>
    <!-- /POST PREVIEW FILTERABLE LIST -->
    <?php

}

?>
