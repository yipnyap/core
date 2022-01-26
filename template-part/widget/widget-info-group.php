<?php
/**
 * Yipnyap Template Part - Widget Info Group
 *
 * @param array $args {
 * @type array $group Group data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_groups_get
 *
 * @package Yipnyap
 */

$group_statuses = [
    'public' => esc_html__('Public', 'yipnyap'),
    'private' => esc_html__('Private', 'yipnyap'),
    'hidden' => esc_html__('Hidden', 'yipnyap')
];

$group_status_string = array_key_exists($args['group']['status'], $group_statuses) ? $group_statuses[$args['group']['status']] : '';

// Add user register date
$information_items = [
    [
        'title' => esc_html__('Created', 'yipnyap'),
        'type' => 'text',
        'value' => date_i18n(get_option('date_format'), strtotime($args['group']['date_created']))
    ],
    [
        'title' => esc_html__('Type', 'yipnyap'),
        'type' => 'text',
        'value' => $group_status_string
    ]
];

/**
 * Widget Info
 */
get_template_part('template-part/widget/widget-info', null, [
    'widget_title' => esc_html__('Group Info', 'yipnyap'),
    'widget_text' => $group['description'],
    'information_items' => $information_items
]);

?>
