<?php
/**
 * Yipnyap Template Part - Nextgen Profile Header
 *
 * @param array $args {
 * @type array $member Member data.
 * @type array $social_links Social links data.
 * }
 * @since hk15
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get, yipnyap_members_get_xprofile_social_links
 *
 * @package Yipnyap
 */

if (!empty($args)) {
    $post_count = $args['member']['stats']['post_count'];
    $friend_count = $args['member']['stats']['friend_count'];
    $follow_count = bp_follow_total_follow_counts([
        'user_id' => $args['member']['id']
    ])['followers'];
}

global $yipnyap_settings;

$display_verified = yipnyap_plugin_bpverifiedmember_is_active();

$display_verified_in_fullname = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_fullname'];
$display_verified_in_username = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_username'];

$verified_user = $display_verified && $args['member']['verified'];

$mature = yipnyap_members_xprofile_get_field_value($args['member'], 'Profile_Meta_Rating');
$primaryColour = yipnyap_members_xprofile_get_field_value($args['member'], 'Account_Info_Profile Primary Accent');
$background = yipnyap_members_xprofile_get_field_value($args['member'], 'Account_Info_Profile Background');

$loggedUser = yipnyap_get_logged_user_member_data();
if (!empty($loggedUser)) {
    $uiPrivacy = strtolower(yipnyap_members_xprofile_get_field_value($loggedUser, 'Account_Info_UI Privacy and Security'));
}

$unicornEngine = get_option('unicorn_engine');
$showCustomisedUINotice = !str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['hide_customised_ui_str']);
if (str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_bg_render_str'])) {
    $background = '';
}

if (str_contains($uiPrivacy ?? '', $unicornEngine['settings_str']['disallow_palette_render_str'])) {
    $primaryColour = '';
}

?>
<style data-use-unicorn-engine>
    :root {
        <?php if (!empty($primaryColour)) { ?>
            --color-primary: <?php echo $primaryColour; ?>;
        <?php } ?>
    }

    #cmui-entire-content {
        /*padding: 0 !important;*/
    <?php if (!empty($background)) { ?>
        background: <?php echo $background; ?> !important;
    <?php } ?>
    }
</style>

<!-- PROFILE HEADER -->
<div id="nextgen-profile-header" data-userid="<?php echo $args['member']['id'] ?>"></div>
