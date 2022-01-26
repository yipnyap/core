<?php
/**
 * Yipnyap Template Part - Avatar Big
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

get_template_part('template-part/avatar/avatar-big', $yipnyap_settings['avatar_type'], $args);

?>
