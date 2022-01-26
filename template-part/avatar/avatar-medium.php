<?php
/**
 * Yipnyap Template Part - Avatar Medium
 *
 * @param array $args {
 * @type array $user User data.
 * @type string $modifiers Optional. Additional class names to add to the HTML wrapper.
 * @type bool $no_border Optional. Adds a border if set.
 * @type bool $linked Optional. Adds a link to the user profile if set.
 * }
 * @since 1.3.6
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get, yipnyap_groups_get
 *
 * @package Yipnyap
 */

global $yipnyap_settings;

$avatar_type = !is_null($yipnyap_settings) ? $yipnyap_settings['avatar_type'] : get_theme_mod('yipnyap_avatar_setting_type', 'hexagon');

get_template_part('template-part/avatar/avatar-medium', $avatar_type, $args);

?>
