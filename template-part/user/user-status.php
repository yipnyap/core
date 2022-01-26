<?php
/**
 * Yipnyap Template Part - User Status
 *
 * @param array $args {
 * @type array $user User data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get
 *
 * @package Yipnyap
 */

global $yipnyap_settings;

$display_verified = yipnyap_plugin_bpverifiedmember_is_active() && $yipnyap_settings['bp_verified_member_display_badge_in_members_lists'];

$display_verified_in_fullname = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_fullname'];
$display_verified_in_username = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_username'];

$verified_user = $display_verified && $args['user']['verified'];

?>

<!-- USER STATUS -->
<div class="user-status">
    <?php

    /**
     * Avatar Small
     */
    get_template_part('template-part/avatar/avatar', 'small', [
        'user' => $args['user'],
        'modifiers' => 'user-status-avatar',
        'linked' => true,
        'no_border' => true
    ]);

    ?>
    <!-- USER STATUS TITLE -->
    <p class="user-status-title">
        <a class="bold"
           href="<?php echo esc_url($args['user']['link']); ?>"><?php echo esc_html($args['user']['name']); ?></a>
        <?php
        if ($display_verified_in_fullname && $verified_user) {
            echo $yipnyap_settings['bp_verified_member_badge'];
        }
        ?>
    </p>
    <!-- /USER STATUS TITLE -->

    <!-- USER STATUS TEXT -->
    <p class="user-status-text small">
        &#64;<?php echo esc_html($args['user']['mention_name']); ?>
        <?php
        if ($display_verified_in_username && $verified_user) {
            echo $yipnyap_settings['bp_verified_member_badge'];
        }
        ?>
    </p>
    <!-- /USER STATUS TEXT -->
</div>
<!-- /USER STATUS -->
