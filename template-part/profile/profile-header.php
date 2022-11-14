<?php
/**
 * Yipnyap Template Part - Profile Header
 *
 * @param array $args {
 * @type array $member Member data.
 * @type array $social_links Social links data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_members_get, yipnyap_members_get_xprofile_social_links
 *
 * @package Yipnyap
 */

if (!empty($args)) {
    $post_count = $args['member']['stats']['post_count'];
    $friend_count = $args['member']['stats']['friend_count'];
    $follow_count = bp_follow_total_follow_counts(array(
        'user_id' => $args['member']['id']
    ))['followers'];
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

    <?php if (!empty($background)) { ?>
    #cmui-entire-content {
        background: <?php echo $background; ?> !important;
    }
    <?php } ?>
</style>

<!-- PROFILE HEADER -->
<div class="profile-header">
    <!-- PROFILE HEADER COVER -->
    <div class="profile-header-cover"
         style="background: url(<?php echo esc_url($args['member']['cover_url']); ?>) center center / cover no-repeat"></div>
    <!-- /PROFILE HEADER COVER -->

    <!-- PROFILE HEADER INFO -->
    <div class="profile-header-info">
        <!-- USER SHORT DESCRIPTION -->
        <div class="user-short-description big">
            <?php

            /**
             * Avatar Big
             */
            get_template_part('template-part/avatar/avatar', 'big', [
                'user' => $args['member'],
                'modifiers' => 'user-short-description-avatar'
            ]);

            /**
             * Avatar Medium
             */
            get_template_part('template-part/avatar/avatar', 'medium', [
                'user' => $args['member'],
                'modifiers' => 'user-short-description-avatar user-short-description-avatar-mobile'
            ]);

            ?>

            <!-- USER SHORT DESCRIPTION TITLE -->
            <p class="user-short-description-title">
                <?php

                echo esc_html($args['member']['name']);

                if ($display_verified_in_fullname && $verified_user) {
                    echo $yipnyap_settings['bp_verified_member_badge'];
                }

                ?>
            </p>
            <!-- /USER SHORT DESCRIPTION TITLE -->

            <!-- USER SHORT DESCRIPTION TEXT -->
            <p class="user-short-description-text">
                <?php

                echo '&#64;' . esc_html($args['member']['mention_name']);

                if ($display_verified_in_username && $verified_user) {
                    echo $yipnyap_settings['bp_verified_member_badge'];
                }

                ?>
            </p>
            <!-- /USER SHORT DESCRIPTION TEXT -->
        </div>
        <!-- /USER SHORT DESCRIPTION -->

        <?php

        $social_links_count = count($args['social_links']);

        if ($social_links_count <= 7) :
            /**
             * Social Links
             */
            get_template_part('template-part/social/social-links', null, [
                'social_links' => $args['social_links']
            ]);
        else :

            ?>
            <!-- PROFILE HEADER SOCIAL LINKS WRAP -->
            <div class="profile-header-social-links-wrap">
                <div id="profile-header-social-links-slider" class="swiper-container">
                    <!-- PROFILE HEADER SOCIAL LINKS -->
                    <div class="profile-header-social-links swiper-wrapper">
                        <?php foreach ($args['social_links'] as $social_link) : ?>
                            <div class="profile-header-social-link swiper-slide">
                                <?php

                                /**
                                 * Social Link
                                 */
                                get_template_part('template-part/social/social-link', null, [
                                    'name' => $social_link['name'],
                                    'link' => $social_link['link']
                                ]);

                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- /PROFILE HEADER SOCIAL LINKS -->
                </div>

                <!-- SLIDER CONTROLS -->
                <div class="slider-controls">
                    <!-- SLIDER CONTROL -->
                    <div id="profile-header-social-links-control-prev" class="slider-control left">
                        <?php

                        /**
                         * Icon SVG
                         */
                        get_template_part('template-part/icon/icon', 'svg', [
                            'icon' => 'small-arrow',
                            'modifiers' => 'slider-control-icon'
                        ]);

                        ?>
                    </div>
                    <!-- /SLIDER CONTROL -->

                    <!-- SLIDER CONTROL -->
                    <div id="profile-header-social-links-control-next" class="slider-control right">
                        <?php

                        /**
                         * Icon SVG
                         */
                        get_template_part('template-part/icon/icon', 'svg', [
                            'icon' => 'small-arrow',
                            'modifiers' => 'slider-control-icon'
                        ]);

                        ?>
                    </div>
                    <!-- /SLIDER CONTROL -->
                </div>
                <!-- /SLIDER CONTROLS -->
            </div>
            <!-- /PROFILE HEADER SOCIAL LINKS WRAP -->
        <?php

        endif;

        if ($social_links_count <= 4) :
            /**
             * Social Links
             */
            get_template_part('template-part/social/social-links', null, [
                'social_links' => $args['social_links'],
                'modifiers' => 'small mobile'
            ]);
        else :

            ?>
            <!-- PROFILE HEADER SOCIAL LINKS WRAP -->
            <div class="profile-header-social-links-wrap mobile">
                <div id="profile-header-social-links-mobile-slider" class="swiper-container">
                    <!-- PROFILE HEADER SOCIAL LINKS -->
                    <div class="profile-header-social-links swiper-wrapper">
                        <?php foreach ($args['social_links'] as $social_link) : ?>
                            <div class="profile-header-social-link swiper-slide">
                                <?php

                                /**
                                 * Social Link
                                 */
                                get_template_part('template-part/social/social-link', null, [
                                    'name' => $social_link['name'],
                                    'link' => $social_link['link'],
                                    'modifiers' => 'small'
                                ]);

                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- /PROFILE HEADER SOCIAL LINKS -->
                </div>

                <!-- SLIDER CONTROLS -->
                <div class="slider-controls">
                    <!-- SLIDER CONTROL -->
                    <div id="profile-header-social-links-mobile-control-prev" class="slider-control left">
                        <?php

                        /**
                         * Icon SVG
                         */
                        get_template_part('template-part/icon/icon', 'svg', [
                            'icon' => 'small-arrow',
                            'modifiers' => 'slider-control-icon'
                        ]);

                        ?>
                    </div>
                    <!-- /SLIDER CONTROL -->

                    <!-- SLIDER CONTROL -->
                    <div id="profile-header-social-links-mobile-control-next" class="slider-control right">
                        <?php

                        /**
                         * Icon SVG
                         */
                        get_template_part('template-part/icon/icon', 'svg', [
                            'icon' => 'small-arrow',
                            'modifiers' => 'slider-control-icon'
                        ]);

                        ?>
                    </div>
                    <!-- /SLIDER CONTROL -->
                </div>
                <!-- /SLIDER CONTROLS -->
            </div>
            <!-- /PROFILE HEADER SOCIAL LINKS WRAP -->
        <?php

        endif;

        ?>
        <!-- USER STATS -->
        <div class="user-stats">
            <!-- USER STAT -->
            <div class="user-stat big">
                <!-- USER STAT TITLE -->
                <p class="user-stat-title"><?php echo esc_html($post_count); ?></p>
                <!-- /USER STAT TITLE -->

                <!-- USER STAT TEXT -->
                <p class="user-stat-text"><?php echo esc_html(_n('post', 'posts', $post_count, 'yipnyap')); ?></p>
                <!-- /USER STAT TEXT -->
            </div>
            <!-- /USER STAT -->

            <?php

            // add BuddyPress friend stats data if friends component is active
            if (bp_is_active('friends')) :

                ?>
                <!-- USER STAT -->
                <div class="user-stat big">
                    <!-- USER STAT TITLE -->
                    <p class="user-stat-title"><?php echo esc_html($friend_count); ?></p>
                    <!-- /USER STAT TITLE -->

                    <!-- USER STAT TEXT -->
                    <p class="user-stat-text"><?php echo esc_html(_n('friend', 'friends', $friend_count, 'yipnyap')); ?></p>
                    <!-- /USER STAT TEXT -->
                </div>
                <!-- /USER STAT -->
            <?php

            endif;

            ?>

            <!-- USER STAT -->
            <div class="user-stat big">
                <!-- USER STAT TITLE -->
                <p class="user-stat-title"><?php echo esc_html($follow_count); ?></p>
                <!-- /USER STAT TITLE -->

                <!-- USER STAT TEXT -->
                <p class="user-stat-text"><?php echo esc_html(_n('follower', 'followers', $follow_count, 'yipnyap')); ?></p>
                <!-- /USER STAT TEXT -->
            </div>
            <!-- /USER STAT -->
        </div>
        <!-- /USER STATS -->

        <?php if (is_user_logged_in()) : ?>
            <!-- PROFILE HEADER ACTIONS -->
            <div id="profile-header-actions" data-allowfriendships="<?php bp_is_active('friends') ?>"
                 data-userid="<?php echo esc_attr($args['member']['id']); ?>"></div>
            <!-- /PROFILE HEADER ACTIONS -->
        <?php endif; ?>
    </div>
    <!-- /PROFILE HEADER INFO -->
</div>
<!-- /PROFILE HEADER -->

<!-- PROFILE HEADER MATURE WARNING -->
<?php
if ($mature === 'NSFW' || $mature === 'Suggestive') {
    get_template_part('template-part/alert/alert', 'line', [
        'type'  => 'error',
        'icon' => 'error',
        'class' => 'mt-4',
        'text'  => '<span class="bold block">Mature User</span>This user may have mature content on their profile.'
    ]);
}
?>
<!-- /PROFILE HEADER MATURE WARNING -->

<!-- PROFILE HEADER THEME WARNING -->
<?php
if ((!empty($primaryColour) || !empty($background)) && $showCustomisedUINotice) {
    get_template_part('template-part/alert/alert', 'line', [
        'type' => 'info',
        'icon' => 'hand-raised',
        'class' => 'mt-4',
        'text' => '<span class="bold block">🎨 User has custom theme</span>Your UI might not look right or consistent. We cannot guarantee user accessibility.'
    ]);
}
?>
<!-- /PROFILE HEADER THEME WARNING -->

