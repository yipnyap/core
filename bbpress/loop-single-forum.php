<?php

/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

// Exit if accessed directly
defined('ABSPATH') || exit;

?>

<ul id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>
    <li class="bbp-forum-info">

        <?php if (bbp_is_user_home() && bbp_is_subscriptions()) : ?>

            <span class="bbp-row-actions">

				<?php do_action('bbp_theme_before_forum_subscription_action'); ?>

                <?php bbp_forum_subscription_link(['before' => '', 'subscribe' => '+', 'unsubscribe' => '&times;']); ?>

                <?php do_action('bbp_theme_after_forum_subscription_action'); ?>

			</span>

        <?php endif; ?>

        <!-- YIPNYAP FORUM INFO WRAP -->
        <div class="yipnyap-forum-info-wrap">

            <?php if (has_post_thumbnail()): ?>
                <!-- YIPNYAP FORUM THUMBNAIL -->
                <a class="yipnyap-forum-thumbnail"
                   href="<?php bbp_forum_permalink(); ?>"><?php the_post_thumbnail('yipnyap-forum-thumb') ?></a>
                <!-- /YIPNYAP FORUM THUMBNAIL -->
            <?php endif; ?>

            <?php

            $forum_id = bbp_get_forum_id();

            if (yipnyap_plugin_buddypress_is_active()) {
                $forum_group_id = bbp_get_forum_group_ids($forum_id);

                if (count($forum_group_id) > 0) {
                    $forum_group = yipnyap_groups_get(['include' => [$forum_group_id[0]]])[0];
                    $forum_group['link'] = bbp_get_forum_permalink($forum_id);

                    /**
                     *
                     */
                    get_template_part('template-part/avatar/avatar', 'forum', [
                        'user' => $forum_group,
                        'no_border' => true,
                        'linked' => true
                    ]);
                }
            }

            ?>

            <!-- YIPNYAP FORUM INFO -->
            <div class="yipnyap-forum-info">

                <?php do_action('bbp_theme_before_forum_title'); ?>

                <a class="bbp-forum-title" href="<?php bbp_forum_permalink(); ?>"><?php bbp_forum_title(); ?></a>

                <?php do_action('bbp_theme_after_forum_title'); ?>

                <?php do_action('bbp_theme_before_forum_description'); ?>

                <div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

                <?php do_action('bbp_theme_after_forum_description'); ?>

                <?php do_action('bbp_theme_before_forum_sub_forums'); ?>

                <?php bbp_list_forums(); ?>

                <?php do_action('bbp_theme_after_forum_sub_forums'); ?>

            </div>
            <!-- /YIPNYAP FORUM INFO -->

        </div>
        <!-- /YIPNYAP FORUM INFO WRAP -->

        <?php bbp_forum_row_actions(); ?>

    </li>

    <li class="bbp-forum-topic-count"><?php bbp_forum_topic_count(); ?></li>

    <li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?></li>

    <li class="bbp-forum-freshness">
        <?php

        $last_activity_data = yipnyap_bbpress_forum_last_activity_get(bbp_get_forum_id());

        if ($last_activity_data) {
            /**
             * Forum Topic Meta
             */
            get_template_part('template-part/forum/forum-topic-meta', null, [
                'last_activity_data' => $last_activity_data
            ]);
        } else {
            esc_html_e('No Topics', 'yipnyap');
        }

        ?>
    </li>
</ul><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
