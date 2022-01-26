<?php
/**
 * Yipnyap Template Part - Widget Info Block Interests
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

$profile_interests_group_name = yipnyap_settings_xprofile_group_profile_interests_name_get();

/**
 * Widget Info Block
 */
get_template_part('template-part/widget/widget-info-block', null, [
    'widget_title' => esc_html__('Interests', 'yipnyap'),
    'information_items' => yipnyap_members_xprofile_get_group_fields($args['member'], $profile_interests_group_name),
    'no_results_text' => esc_html__('No interests found', 'yipnyap')
]);

?>
