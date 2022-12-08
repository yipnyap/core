<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$YipnyapPageTemplates = [
    [
        'slug' => 'settings',
        'title' => 'Settings',
    ]
];

// Loop through each page template
foreach ($YipnyapPageTemplates as $YipnyapPageTemplate) {
    // Create the page
    $YipnyapPage = get_page_by_path($YipnyapPageTemplate['slug'], OBJECT, 'page');
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