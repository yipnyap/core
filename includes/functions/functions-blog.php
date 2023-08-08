<?php
/**
 * Yipnyap BLOG functions
 *
 * @since 1.0.0
 */

if (!function_exists('yipnyap_post_get_image')) {
    /**
     * Get post image url
     *
     * @param int $post_id ID of the post to get the image from
     * @return string
     */
    function yipnyap_post_get_image($post_id)
    {
        $thumbnail_id = get_post_thumbnail_id($post_id);

        $thumbnail_post = get_post($thumbnail_id);

        return $thumbnail_post->guid;
    }
}

if (!function_exists('yipnyap_get_posts')) {
    /**
     * Returns filtered posts
     *
     * @param array $args Filter arguments for post query
     * @return array
     */
    function yipnyap_get_posts($args)
    {
        // get posts
        $wp_posts = get_posts($args);

        $posts = [];

        foreach ($wp_posts as $wp_post) {
            $post = [
                'id' => $wp_post->ID,
                'type' => 'post',
                'post_type' => $wp_post->post_type,
                'format' => get_post_format($wp_post->ID),
                'timestamp' => get_the_date('', $wp_post->ID),
                'excerpt' => get_the_excerpt($wp_post->ID),
                'permalink' => get_permalink($wp_post->ID),
                'title' => $wp_post->post_title,
                'cover_url' => false,
                'cover_url_thumb' => false,
                'postv1_cover_url' => false,
                'postv2_cover_url' => false,
                'share_count' => (int)yipnyap_post_get_share_count($wp_post->ID),
                'comment_count' => (int)$wp_post->comment_count,
                'reactions' => [],
                'categories' => [],
                'tags' => [],
                'comment_status' => $wp_post->comment_status,
                'ping_status' => $wp_post->ping_status,
                'post_password' => $wp_post->post_password,
                'password_required' => post_password_required($wp_post->ID)
            ];

            $post['author'] = yipnyap_members_get(['include' => [$wp_post->post_author]])[0];

            // if no author data available, show as deleted
            if (count($post['author']) === 0) {
                $post['author'] = [
                    'id' => $wp_post->post_author,
                    'name' => esc_html__('[deleted]', 'yipnyap'),
                    'mention_name' => esc_html__('[deleted]', 'yipnyap'),
                    'link' => '',
                    'media_link' => '',
                    'badges_link' => '',
                    'avatar_url' => yipnyap_get_default_member_avatar_url(),
                    'rank' => [
                        'current' => 0,
                        'total' => 0
                    ],
                    'verified' => false
                ];
            }

            $post['reactions'] = yipnyap_reactions_insert_user_data(vkreact_get_post_reactions($wp_post->ID));

            // add post format information
            if ($post['format'] === 'video') {
                $videoURL = get_post_meta($wp_post->ID, 'yipnyap_video_url', true);
                $post['video_url'] = $videoURL;
            } else if ($post['format'] === 'audio') {
                $audioURL = get_post_meta($wp_post->ID, 'yipnyap_audio_url', true);

                $post['audio_url'] = $audioURL;
            } else if ($post['format'] === 'gallery') {
                $attachment_ids = get_post_meta($wp_post->ID, 'yipnyap_gallery_ids', true);

                if ($attachment_ids[0] !== '') {
                    $attachment_ids = explode(',', $attachment_ids);

                    $post['gallery'] = [];

                    foreach ($attachment_ids as $attachment_id) {
                        $attachment = [];
                        $attachment['id'] = $attachment_id;
                        $attachment['url'] = wp_get_attachment_url($attachment_id);
                        $post['gallery'][] = $attachment;
                    }
                } else {
                    $post['gallery'] = false;
                }
            }

            // if user uploaded a custom cover
            if (has_post_thumbnail($wp_post->ID)) {
                // get user custom cover url
                $post['cover_url'] = get_the_post_thumbnail_url($wp_post->ID);
                $post['cover_url_thumb'] = get_the_post_thumbnail_url($wp_post->ID, 'yipnyap-postlist-thumb');
                $post['postv1_cover_url'] = get_the_post_thumbnail_url($wp_post->ID, 'yipnyap-postv1-fullscreen');
                $post['postv2_cover_url'] = get_the_post_thumbnail_url($wp_post->ID, 'yipnyap-postv2-fullscreen');
            }

            // get post categories
            $categories = get_the_category($wp_post->ID);

            foreach ($categories as $category) {
                $post_cat = get_category($category);

                $cat = [];
                $cat['id'] = $post_cat->cat_ID;
                $cat['name'] = $post_cat->name;
                $cat['link'] = get_category_link($post_cat->cat_ID);

                $post['categories'][] = $cat;
            }

            // get post tags
            $tags = get_the_tags($wp_post->ID);

            if ($tags) {
                foreach ($tags as $tag) {
                    $t = [];
                    $t['id'] = $tag->term_id;
                    $t['name'] = $tag->name;
                    $t['link'] = get_tag_link($tag->term_id);

                    $post['tags'][] = $t;
                }
            }

            $posts[] = $post;
        }

        return $posts;
    }
}

if (!function_exists('yipnyap_get_post_count')) {
    /**
     * Get filtered post count
     *
     * @param array $args Post filters.
     * @return int  $post_count   Filtered post count.
     */
    function yipnyap_get_post_count($args)
    {
        $defaults = [
            'numberposts' => -1
        ];

        $args = array_merge($defaults, $args);

        $posts = get_posts($args);
        $post_count = count($posts);

        return $post_count;
    }
}

if (!function_exists('yipnyap_post_comment_delete')) {
    /**
     * Delete post comment
     *
     * @param int $comment_id ID of the comment to delete.
     * @return bool True if successfull delete, false otherwise.
     */
    function yipnyap_post_comment_delete($comment_id)
    {
        return wp_delete_comment($comment_id, true);
    }
}

if (!function_exists('yipnyap_post_comment_children_delete')) {
    /**
     * Delete post comment children
     *
     * @param int $comment_id ID of the comment to delete all children from.
     */
    function yipnyap_post_comment_children_delete($comment_id)
    {
        global $wpdb;

        $comment_children = $wpdb->get_col(
            $wpdb->prepare("SELECT comment_ID FROM $wpdb->comments WHERE comment_parent = %d", $comment_id)
        );

        if (!empty($comment_children)) {
            foreach ($comment_children as $comment_child => $comment_child_id) {
                yipnyap_post_comment_delete($comment_child_id);
            }
        }
    }
}

add_action('delete_comment', 'yipnyap_post_comment_children_delete');

if (!function_exists('yipnyap_post_get_sticky_posts')) {
    /**
     * Returns sticky posts
     *
     * @return array $sticky_posts      Sticky posts data.
     */
    function yipnyap_post_get_sticky_posts()
    {
        $sticky_post_ids = get_option('sticky_posts');

        $sticky_posts = [];

        // if sticky posts found
        if (count($sticky_post_ids) > 0) {
            $sticky_posts = yipnyap_get_posts(['include' => $sticky_post_ids]);
        }

        return $sticky_posts;
    }
}

if (!function_exists('yipnyap_post_get_loop_data')) {
    /**
     * Get post loop data
     */
    function yipnyap_post_get_loop_data()
    {
        $author_id = get_the_author_meta('ID');
        $post_format = get_post_format();
        $post_type = get_theme_mod('yipnyap_blog_setting_type', 'v1');

        if (in_array($post_format, ['video', 'audio', 'gallery'])) {
            $post_type = 'v3';
        }

        $post_id = get_the_ID();

        $post_data = [
            'id' => $post_id,
            'format' => $post_format,
            'type' => $post_type,
            'categories' => get_the_category(),
            'date' => get_the_date(),
            'title' => get_the_title(),
            'cover_url' => false,
            'cover_url_thumb' => false,
            'link' => get_permalink(),
            'excerpt_from_text' => get_the_excerpt(),
            'comment_count' => get_comments_number(),
            'share_count' => yipnyap_post_get_share_count($post_id)
        ];

        $post_data['author'] = yipnyap_members_get(['include' => [$author_id]])[0];

        // if no author data available, show as deleted
        if (count($post_data['author']) === 0) {
            $post_data['author'] = [
                'id' => $author_id,
                'name' => esc_html__('[deleted]', 'yipnyap'),
                'mention_name' => esc_html__('[deleted]', 'yipnyap'),
                'link' => '',
                'media_link' => '',
                'badges_link' => '',
                'avatar_url' => yipnyap_get_default_member_avatar_url(),
                'verified' => false
            ];
        }

        // if user uploaded a custom cover
        if (has_post_thumbnail($post_id)) {
            // get user custom cover url
            $post_data['cover_url'] = get_the_post_thumbnail_url($post_id);
            $post_data['cover_url_thumb'] = get_the_post_thumbnail_url($post_id, 'yipnyap-postlist-thumb');

            if ($post_type === 'v1') {
                $post_data['cover_url'] = get_the_post_thumbnail_url($post_id, 'yipnyap-postv1-fullscreen');
            } else if ($post_type === 'v2') {
                $post_data['cover_url'] = get_the_post_thumbnail_url($post_id, 'yipnyap-postv2-fullscreen');
            }
        }

        // only add excerpt data if it exists
        if (has_excerpt()) {
            $post_data['excerpt'] = get_the_excerpt();
        }

        // only add tags data if they exist
        $tags = get_the_tags();

        if ($tags) {
            $post_data['tags'] = $tags;
        }

        return $post_data;
    }
}

if (!function_exists('yipnyap_get_pages')) {
    /**
     * Returns filtered pages
     *
     * @param array $args Filter arguments for page query
     * @return array
     */
    function yipnyap_get_pages($args)
    {
        // get pages
        $wp_pages = get_pages($args);

        $pages = [];

        foreach ($wp_pages as $wp_page) {
            $page = [
                'id' => $wp_page->ID,
                'type' => 'page',
                'title' => $wp_page->post_title,
                'cover_url' => false,
                'cover_url_thumb' => false,
                'comment_count' => (int)$wp_page->comment_count,
                'share_count' => 0,
                'comment_status' => $wp_page->comment_status,
                'reactions' => []
            ];

            // if user uploaded a custom cover
            if (has_post_thumbnail($wp_page->ID)) {
                // get user custom cover url
                $page['cover_url'] = get_the_post_thumbnail_url($wp_page->ID);
                $page['cover_url_thumb'] = get_the_post_thumbnail_url($wp_page->ID, 'yipnyap-postlist-thumb');
            }

            $page['reactions'] = yipnyap_reactions_insert_user_data(vkreact_get_post_reactions($wp_page->ID));

            $pages[] = $page;
        }

        return $pages;
    }
}

if (!function_exists('yipnyap_page_get_loop_data')) {
    /**
     * Get page loop data
     */
    function yipnyap_page_get_loop_data()
    {
        $post_id = get_the_ID();

        $post_data = [
            'id' => $post_id,
            'type' => 'page',
            'title' => get_the_title(),
            'cover_url' => false,
            'cover_url_thumb' => false,
            'comment_count' => get_comments_number(),
            'share_count' => yipnyap_post_get_share_count($post_id),
            'allow_comments' => comments_open()
        ];

        // if user uploaded a custom cover
        if (has_post_thumbnail($post_id)) {
            // get user custom cover url
            $post_data['cover_url'] = get_the_post_thumbnail_url($post_id);
            $post_data['cover_url_thumb'] = get_the_post_thumbnail_url($post_id, 'yipnyap-postlist-thumb');
        }

        return $post_data;
    }
}

if (!function_exists('yipnyap_post_get_share_count')) {
    /**
     * Gets post share count
     *
     * @param int $post_id ID of the post to get share count of.
     * @return int  $share_count      Share count of the post.
     */
    function yipnyap_post_get_share_count($post_id)
    {
        $share_count = get_post_meta($post_id, 'share_count', true);

        return !empty($share_count) ? $share_count : 0;
    }
}

if (!function_exists('yipnyap_get_post_meta')) {
    /**
     * Get post meta
     *
     * @param array $args Post meta args
     * @return int|boolean
     */
    function yipnyap_get_post_meta($args)
    {
        $result = get_post_meta($args['post_id'], $args['meta_key'], $args['meta_single']);

        // metadata value
        return $result;
    }
}

if (!function_exists('yipnyap_update_post_meta')) {
    /**
     * Update post meta
     *
     * @param array $args Post meta args
     * @return int|boolean
     */
    function yipnyap_update_post_meta($args)
    {
        $result = update_post_meta($args['post_id'], $args['meta_key'], $args['meta_value']);

        // metadata ID on new meta created, true on meta update, false on error
        return $result;
    }
}

if (!function_exists('yipnyap_get_posts_query')) {
    /**
     * Returns filtered post query
     *
     * @param array $args Filter arguments for post query
     * @return WP_Query
     */
    function yipnyap_get_posts_query($args)
    {
        // configuration to get posts
        $query_args = [
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => $args['post_count']
        ];

        if (!empty($args['post_ID'])) {
            $query_args['post__not_in'] = [$args['post_ID']];
        }

        // related posts
        if ($args['query'] === 'related') {
            if (empty($args['related_by'])) {
                $args['related_by'] = 'tag';
            }

            if ($args['related_by'] === 'all_and' || $args['related_by'] === 'tag') {
                // require current post tags in post search
                $query_args['tag__in'] = yipnyap_get_post_tags_IDs($args['post_ID']);
            }

            if ($args['related_by'] === 'all_and' || $args['related_by'] === 'category') {
                // require current post categories in post search
                $query_args['category__in'] = yipnyap_get_post_categories_IDs($args['post_ID']);
            }

            if ($args['related_by'] === 'all_or') {
                $query_args['tax_query'] = [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'category',
                        'terms' => yipnyap_get_post_categories_IDs($args['post_ID']),
                        'include_children' => false
                    ],
                    [
                        'taxonomy' => 'post_tag',
                        'terms' => yipnyap_get_post_tags_IDs($args['post_ID'])
                    ]
                ];
            }
            // popular posts
        } else if ($args['query'] === 'popular') {
            $query_args['orderby'] = 'comment_count';
        }

        // reset post data to create a new query
        wp_reset_postdata();

        // create posts query
        return new WP_Query($query_args);
    }
}

if (!function_exists('yipnyap_get_post_tags_IDs')) {
    /**
     * Returns post tags IDs
     *
     * @param int $post_ID Post ID to get tags from
     * @return array
     */
    function yipnyap_get_post_tags_IDs($post_ID)
    {
        // get post tags
        $tags = get_the_tags($post_ID);

        $tags_ids = [];

        // if post has tags
        if ($tags) {
            foreach ($tags as $tag) {
                $tags_ids[] = $tag->term_id;
            }

            return $tags_ids;
        }

        return $tags_ids;
    }
}

if (!function_exists('yipnyap_get_post_categories_IDs')) {
    /**
     * Returns post categories IDs
     *
     * @param int $post_ID Post ID to get categories from
     * @return array
     */
    function yipnyap_get_post_categories_IDs($post_ID)
    {
        // get post categories
        $categories = get_the_category($post_ID);

        $categories_ids = [];

        // if post has categories
        if ($categories) {
            foreach ($categories as $tag) {
                $categories_ids[] = $tag->term_id;
            }

            return $categories_ids;
        }

        return $categories_ids;
    }
}

if (!function_exists('yipnyap_blog_post_types_default_get')) {
    /**
     * Get default post types
     *
     * @return string   Comma separated post types.
     */
    function yipnyap_blog_post_types_default_get()
    {
        return 'post';
    }
}

if (!function_exists('yipnyap_blog_post_types_to_display_in_blog_get')) {
    /**
     * Get post types to display in site blog.
     *
     * @return array   Post types.
     */
    function yipnyap_blog_post_types_to_display_in_blog_get()
    {
        $post_types_to_display = get_theme_mod('yipnyap_blog_setting_post_types_to_display_in_blog', yipnyap_blog_post_types_default_get());

        return explode(',', $post_types_to_display);
    }
}

if (!function_exists('yipnyap_blog_post_types_to_display_in_search_get')) {
    /**
     * Get post types to display in site search.
     *
     * @return array   Post types.
     */
    function yipnyap_blog_post_types_to_display_in_search_get()
    {
        $post_types_to_display = get_theme_mod('yipnyap_blog_setting_post_types_to_display_in_search', yipnyap_blog_post_types_default_get());

        return explode(',', $post_types_to_display);
    }
}

if (!function_exists('yipnyap_blog_post_type_filter_display_is_enabled')) {
    /**
     * Returns if post type filter display is enabled.
     *
     * @return bool $post_type_filter_is_enabled   True if enabled, false otherwise.
     */
    function yipnyap_blog_post_type_filter_display_is_enabled()
    {
        $post_type_filter_is_enabled = get_theme_mod('yipnyap_blog_setting_post_type_filter_display', 'disabled') === 'enabled';

        return $post_type_filter_is_enabled;
    }
}

if (!function_exists('yipnyap_blog_post_type_split_display_is_enabled')) {
    /**
     * Returns if post type split display is enabled.
     *
     * @return bool $post_type_split_is_enabled   True if enabled, false otherwise.
     */
    function yipnyap_blog_post_type_split_display_is_enabled()
    {
        $post_type_split_is_enabled = get_theme_mod('yipnyap_blog_setting_post_type_split_display', 'disabled') === 'enabled';

        return $post_type_split_is_enabled;
    }
}

/**
 * Get post share count meta creation task
 *
 * @param array $args Parameters to give to the task
 * @return Yipnyap_Task
 */
function yipnyap_post_create_meta_share_count_task($args)
{
    $task_execute = function ($args) {
        $meta_args = [
            'post_id' => $args['id'],
            'meta_key' => 'share_count',
            'meta_value' => $args['count']
        ];

        $result = yipnyap_update_post_meta($meta_args);

        if ($result) {
            return $args['id'];
        }

        return false;
    };

    $task_rewind = function ($args, $post_id) {

    };

    $task = new Yipnyap_Task($task_execute, $task_rewind, $args);

    return $task;
}

?>
