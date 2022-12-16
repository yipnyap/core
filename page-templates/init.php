<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$YipnyapPageTemplates = [
//    [
//        'slug' => 'settings',
//        'title' => 'Settings',
//        'children' => []
//    ]
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
    update_post_meta($YipnyapPageId, '_wp_page_template', 'page-templates/page_' . $YipnyapPageTemplate['slug'] . '.php');
}

add_filter('template_include', function($template) {
    $prefix = '/settings'; // Your prefix
    $prefixExist = str_starts_with($_SERVER['REQUEST_URI'], $prefix);

    if ($prefixExist) {
        header('HTTP/1.1 200 OK');

        add_filter('document_title_parts', function ($title_parts) {
            $title_parts['title'] = 'Settings';
            return $title_parts;
        });

        return locate_template('page-templates/page_settings.php');
    }

    return $template;
});