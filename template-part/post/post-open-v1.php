<?php
/**
 * Yipnyap Template Part - Post Open V1
 *
 * @param array $args {
 * @type array $post Post data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_post_get_loop_data
 *
 * @package Yipnyap
 */

$blog_sidebar_is_active = is_active_sidebar('blog_bottom');
$post_classes = ['post-open'];

if (!$args['post']['cover_url']) {
    $post_classes[] = 'no-cover';
}

global $yipnyap_settings;

$display_verified = yipnyap_plugin_bpverifiedmember_is_active() && $yipnyap_settings['bp_verified_member_display_badge_in_wp_posts'];

$display_verified_in_fullname = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_fullname'];
$display_verified_in_username = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_username'];

$verified_user = $args['post']['author']['verified'];

$breadcrumbs = [];
foreach ($args['post']['categories'] as $category) {
    $breadcrumbs[] = [
        'title' => esc_html($category->name),
        'url' => esc_url($category->name === 'Arcana' ? '/voidhound_/arcana/' : get_category_link($category->cat_ID))
    ];
}
$breadcrumbs[] = [
    'title' => esc_html($args['post']['title']),
    'url' => esc_url(get_permalink($args['post']['id']))
];
get_template_part('template-part/common/header/header', '', [
    'title' => $args['post']['title'],
    'icon' => 'newspaper',
    'breadcrumbs' => $breadcrumbs,
]);
?>

<style>
    .content-actions {
        padding-right: 2em;
    }
</style>

<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Post Card -->
            <div class="bg-box border border-divider rounded-xl">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex-shrink-0">
                            <a href="<?php echo esc_url($args['post']['author']['link']); ?>">
                                <img class="h-10 w-10 rounded-full" src="<?php echo esc_url($args['post']['author']['avatar_url']); ?>" alt="<?php echo esc_attr($args['post']['author']['name']); ?>">
                            </a>
                        </div>
                        <div class="mt-3 md:mt-0 md:ml-4">
                            <div class="text-sm">
                                <a href="<?php echo esc_url($args['post']['author']['link']); ?>" class="font-medium text-primary-600 hover:text-primary-500">
                                    <?php echo esc_html($args['post']['author']['mention_name']); ?>
                                </a>
                                <?php if ($display_verified_in_fullname && $verified_user) : ?>
                                    <span class="ml-1">
                                                <?php echo yipnyap_plugin_bpverifiedmember_get_badge(); ?>
                                            </span>
                                <?php endif; ?>
                            </div>
                            <div class="flex space-x-1 text-xs text-secondary-500">
                                        <span class="text-alt">
                                            <?php echo esc_html($args['post']['date']); ?>
                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <?php if ($args['post']['cover_url']) : ?>
                            <div class="aspect-w-16 aspect-h-9">
                                <img class="object-cover rounded-xl" src="<?php echo esc_url($args['post']['cover_url']); ?>" alt="<?php echo esc_attr($args['post']['title']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="mt-6 prose max-w-none text-secondary-900">
                            <div class="post-open-content-body">

                                <?php

                                wp_reset_postdata();

                                the_content();

                                wp_link_pages();

                                ?>

                                <?php
                                if (isset($args['post']['tags'])) {
                                    /**
                                     * Tag List
                                     */
                                    get_template_part('template-part/tag/tag', 'list', [
                                        'tags' => $args['post']['tags']
                                    ]);
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($args['post']['categories'])) : ?>
                        <div class="mt-6">
                            <div class="flex flex-wrap -m-1">
                                <?php foreach ($args['post']['categories'] as $category) : ?>
                                    <a href="<?php echo esc_url(get_category_link($category->cat_ID)); ?>" class="m-1 inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-box-over">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-6 w-full">
                    <div id="comment-list" data-postid="<?php echo esc_attr($args['post']['id']); ?>"></div>
                </div>
            </div>
        </div>
    </div>
</main>
