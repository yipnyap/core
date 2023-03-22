<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$YipnyapPageTemplates = [
    [
        'slug' => 'notifications',
        'title' => 'Notifications',
        'nextgen' => true,
        'children' => [],
    ],
    [
        'slug' => 'fund',
        'title' => 'Fund',
        'nextgen' => true,
        'children' => [],
    ],
];

// Loop through each page template
foreach ($YipnyapPageTemplates as $YipnyapPageTemplate) {
    // Create the page
    $YipnyapPage = get_page_by_path($YipnyapPageTemplate['slug']);
    if (!$YipnyapPage) {
        $YipnyapPage = [
            'post_title' => $YipnyapPageTemplate['title'],
            'post_name' => $YipnyapPageTemplate['slug'],
            'post_status' => 'publish',
            'post_type' => 'page',
        ];
        $YipnyapPageId = wp_insert_post($YipnyapPage);
    } else {
        $YipnyapPageId = $YipnyapPage->ID;
    }

    // Set the page template
    update_post_meta($YipnyapPageId, '_wp_page_template', 'page-templates/' . ($YipnyapPageTemplate['nextgen'] ? 'nextgen' : 'page_' . $YipnyapPageTemplate['slug']) . '.php');
}

add_filter('template_include', function ($template) {
    $prefix = '/settings'; // Your prefix
    $prefixExist = str_starts_with($_SERVER['REQUEST_URI'], $prefix);

    if ($prefixExist) {
        header('HTTP/1.1 200 OK');

        add_filter('document_title_parts', function ($title_parts) {
            $title_parts['title'] = 'Settings';
            return $title_parts;
        });

        return locate_template('page-templates/nextgen_locked.php');
    }

    return $template;
});

add_filter('template_include', function ($template) {
    $prefix = '/id'; // Your prefix
    $prefixExist = str_starts_with($_SERVER['REQUEST_URI'], $prefix);

    if ($prefixExist) {
        header('HTTP/1.1 200 OK');

        add_filter('document_title_parts', function ($title_parts) {
            $title_parts['title'] = 'ID';
            return $title_parts;
        });

        return locate_template('page-templates/nextgen.php');
    }

    return $template;
});

add_filter('template_include', function ($template) {
    $prefix = '/groups'; // Your prefix
    $prefixExist = str_starts_with($_SERVER['REQUEST_URI'], $prefix);

    if ($prefixExist) {
        header('HTTP/1.1 200 OK');

        add_filter('document_title_parts', function ($title_parts) {
            $title_parts['title'] = 'Groups';
            return $title_parts;
        });

        return locate_template('page-templates/nextgen.php');
    }

    return $template;
});

add_filter('bp_setup_nav', function () {
    global $bp;
    bp_core_new_nav_item([
        'name' => 'Arcana',
        'slug' => 'arcana',
        'parent_url' => $bp->displayed_user->domain,
        'parent_slug' => $bp->profile->slug,
        'screen_function' => function () {
            add_action('bp_template_content', function () {
                echo 'Arcana';
            });
            bp_core_load_template(apply_filters('bp_core_template_plugin', 'members/single/plugins'));
        },
        'position' => 200,
        'default_subnav_slug' => 'arcana',
    ]);
}, 100);
