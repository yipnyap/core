<?php
/**
 * Yipnyap Template Part - Widget Info About
 *
 * @param array $args {
 * @type array $member Member data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get
 *
 * @package Yipnyap
 */

$user = get_userdata($member['id']);

// Add user register date
$information_items = [
    [
        'title' => esc_html__('Joined', 'yipnyap'),
        'type' => 'text',
        'value' => date_i18n(get_option('date_format'), strtotime($user->user_registered))
    ]
];

$profile_bio_group_name = yipnyap_settings_xprofile_group_profile_bio_name_get();

$profile_bio_about_field_name = yipnyap_settings_xprofile_field_profile_bio_about_name_get();

// get Bio information, except for the About field
$bio_information = yipnyap_members_xprofile_get_group_fields($args['member'], $profile_bio_group_name, [$profile_bio_about_field_name]);

// add bio information to the information items to display
$information_items = array_merge($information_items, $bio_information);

/**
 * Widget Info
 */
get_template_part('template-part/widget/widget-info', null, [
    'widget_title' => esc_html__('About Me', 'yipnyap'),
    'widget_text' => yipnyap_members_xprofile_get_field_value($args['member'], $profile_bio_group_name . '_' . $profile_bio_about_field_name),
    'information_items' => $information_items
]);

?>
