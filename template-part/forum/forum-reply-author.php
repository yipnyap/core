<?php
/**
 * Yipnyap Template Part - Forum Reply Author
 *
 * @param array $args {
 * @type array $author Author data.
 * }
 *
 * @var object $args
 *
 * @since 1.3.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_bbpress_reply_author_get, yipnyap_bbpress_author_role_get
 *
 * @package Yipnyap
 */

$yipnyap_settings = yipnyap_bpverifiedmember_settings_get('replies');

$display_verified = yipnyap_plugin_bpverifiedmember_is_active() && $yipnyap_settings['bp_verified_member_display_badge_in_bbp_replies'];

$display_verified_in_fullname = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_fullname'];
$display_verified_in_username = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_username'];

$verified_author = $args['author']['verified'];

?>

<!-- FORUM REPLY AUTHOR -->
<div class="yipnyap-forum-reply-author">
    <?php

    /**
     * Avatar
     */
    get_template_part('template-part/avatar/avatar', null, [
        'user' => $args['author'],
        'linked' => true,
        'no_border' => true,
        'modifiers' => 'yipnyap-forum-reply-author-avatar'
    ]);

    ?>
    <!-- YIPNYAP FORUM REPLY AUTHOR TITLE -->
    <p class="yipnyap-forum-reply-author-title">
        <a href="<?php echo esc_url($args['author']['link']); ?>">
            <?php

            echo esc_html($args['author']['name']);

            if ($display_verified_in_fullname && $verified_author) {
                echo yipnyap_bpverifiedmember_badge_get();
            }

            ?>
        </a>
    </p>
    <!-- /YIPNYAP FORUM REPLY AUTHOR TITLE -->

    <!-- YIPNYAP FORUM REPLY AUTHOR TEXT -->
    <p class="yipnyap-forum-reply-author-text">
        <a href="<?php echo esc_url($args['author']['link']); ?>">
            <?php

            echo '&#64;' . esc_html($args['author']['mention_name']);

            if ($display_verified_in_username && $verified_author) {
                echo yipnyap_bpverifiedmember_badge_get();
            }

            ?>
        </a>
    </p>
    <!-- /YIPNYAP FORUM REPLY AUTHOR TEXT -->

    <!-- YIPNYAP FORUM REPLY AUTHOR ROLE -->
    <p class="yipnyap-forum-reply-author-role"><?php echo esc_html($args['author']['role']); ?></p>
    <!-- /YIPNYAP FORUM REPLY AUTHOR ROLE -->
</div>
<!-- /FORUM REPLY AUTHOR -->
