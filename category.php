<?php
/**
 * Yipnyap Template - Category
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

get_header();

$category = get_queried_object();

get_template_part('template-part/common/header/header', '', [
    'title' => $category->name,
    'icon' => 'newspaper',
    'breadcrumbs' => [
        [
            'title' => 'Blog',
            'url' => '/blog',
        ],
        [
            'title' => $category->name,
            'url' => get_category_link($category->term_id),
        ]
    ],
]);
?>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <?php
            /**
             * Post Filterable List
             */
            get_template_part('template-part/post/post-filterable-list', null, [
                'attributes' => [
                    'category' => $category->cat_ID
                ]
            ]);

            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
