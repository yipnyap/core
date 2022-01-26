<?php
/**
 * Yipnyap Template Part - Forum Description Notice
 *
 * @param array $args {
 * @type array $last_activity_description_data Last activity description data.
 * }
 * @since 1.3.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_bbpress_forum_last_activity_description_get
 *
 * @package Yipnyap
 */

$yipnyap_settings = yipnyap_bpverifiedmember_settings_get('topics');

$display_verified = yipnyap_plugin_bpverifiedmember_is_active() && $yipnyap_settings['bp_verified_member_display_badge_in_bbp_topics'];

$verified_user = array_key_exists('author', $args['last_activity_description_data']) ? $args['last_activity_description_data']['author']['verified'] : false;

?>

<!-- BBP TEMPLATE NOTICE -->
<div class="bbp-template-notice info">
    <ul>
        <li class="bbp-forum-description">
            <?php

            echo wp_kses($args['last_activity_description_data']['text'], ['a' => ['href' => [], 'title' => []]]);

            if (array_key_exists('author', $args['last_activity_description_data'])) :

                ?>
                <!-- BBP FORUM DESCRIPTION AUTHOR -->
                <div class="bbp-forum-description-author">
                    <?php

                    /**
                     * Avatar Micro
                     */
                    get_template_part('template-part/avatar/avatar', 'micro', [
                        'user' => $args['last_activity_description_data']['author'],
                        'linked' => true,
                        'no_border' => true,
                        'modifiers' => 'bbp-forum-description-author-avatar'
                    ]);

                    ?>
                    <!-- BBP FORUM DESCRIPTION AUTHOR TITLE -->
                    <a href="<?php echo esc_url($args['last_activity_description_data']['author']['link']); ?>"
                       class="bbp-forum-description-author-title">
                        <?php

                        echo esc_html($args['last_activity_description_data']['author']['name']);

                        if ($display_verified && $verified_user) {
                            echo yipnyap_bpverifiedmember_badge_get();
                        }

                        ?>
                    </a>
                    <!-- /BBP FORUM DESCRIPTION AUTHOR TITLE -->
                </div>
                <!-- /BBP FORUM DESCRIPTION AUTHOR -->
            <?php

            endif;

            ?>
        </li>
    </ul>
</div>
<!-- /BBP TEMPLATE NOTICE -->
