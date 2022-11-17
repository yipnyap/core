<?php
/**
 * Yipnyap Template Part - Post Open V3
 *
 * @param array $args {
 * @type array $post Post data.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_post_get_loop_data
 *
 * @package Yipnyap
 */

$blog_sidebar_is_active = is_active_sidebar('blog');
$blog_sidebar_classes = $blog_sidebar_is_active ? 'grid-3-9' : '';
$post_classes = ['post-open', 'v3', 'full'];

global $yipnyap_settings;

$display_verified = yipnyap_plugin_bpverifiedmember_is_active() && $yipnyap_settings['bp_verified_member_display_badge_in_wp_posts'];

$display_verified_in_fullname = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_fullname'];
$display_verified_in_username = $display_verified && $yipnyap_settings['bp_verified_member_display_badge_in_profile_username'];

$verified_user = $args['post']['author']['verified'];

?>

<!-- CONTENT GRID -->
<div class="content-grid">
    <!-- GRID -->
    <div class="grid <?php echo esc_attr($blog_sidebar_classes); ?> centered">
        <?php if ($blog_sidebar_is_active) : ?>
            <!-- POST OPEN SIDEBAR -->
            <div class="post-open-sidebar grid-column">
                <?php get_sidebar('blog'); ?>
            </div>
            <!-- /POST OPEN SIDEBAR -->
        <?php endif; ?>

        <!-- POST OPEN -->
        <article <?php post_class($post_classes); ?>>
            <!-- POST OPEN HEADING -->
            <div class="post-open-heading">
                <!-- POST OPEN TIMESTAMP -->
                <p class="post-open-timestamp">
                    <?php foreach ($args['post']['categories'] as $category): ?>
                        <a href="<?php echo esc_url(get_category_link($category->cat_ID)); ?>"><?php echo esc_html($category->name); ?></a> -
                    <?php endforeach; ?>

                    <?php echo esc_html($args['post']['date']); ?>
                </p>
                <!-- /POST OPEN TIMESTAMP -->

                <!-- POST OPEN TITLE -->
                <h2 class="post-open-title"><?php echo esc_html($args['post']['title']); ?></h2>
                <!-- /POST OPEN TITLE -->

                <!-- POST OPEN HEADING META -->
                <div class="post-open-heading-meta">
                    <?php

                    /**
                     * Author Preview
                     */
                    get_template_part('template-part/author/author-preview', null, [
                        'user' => $args['post']['author'],
                        'modifiers' => 'author-preview-landscape',
                        'linked' => yipnyap_plugin_buddypress_is_active(),
                        'display_verified_in_fullname' => $display_verified_in_fullname && $verified_user,
                        'display_verified_in_username' => $display_verified_in_username && $verified_user
                    ]);

                    ?>
                </div>
                <!-- /POST OPEN HEADING META -->
            </div>
            <!-- /POST OPEN HEADING -->

            <?php
            if ($args['post']['format'] === 'video') :
                $video_url = get_post_meta($args['post']['id'], 'yipnyap_video_url', true);

                if ($video_url !== '') :
                    ?>
                    <div class="iframe-wrap">
                        <iframe src="<?php echo esc_url($video_url); ?>" allow="autoplay" allowfullscreen></iframe>
                    </div>
                <?php
                endif;
            elseif ($args['post']['format'] === 'audio') :
                $audio_url = get_post_meta($args['post']['id'], 'yipnyap_audio_url', true);

                if ($audio_url !== '') :
                    ?>
                    <div class="iframe-wrap">
                        <iframe src="<?php echo esc_url($audio_url); ?>" allow="autoplay" allowfullscreen></iframe>
                    </div>
                <?php
                endif;
            elseif (($args['post']['format'] === 'gallery')) :
                $attachment_ids = get_post_meta($args['post']['id'], 'yipnyap_gallery_ids', true);

                if ($attachment_ids[0] !== '') :
                    $attachment_ids = explode(',', $attachment_ids);

                    $gallery = [];
                    $galleryData = [];

                    foreach ($attachment_ids as $attachment_id) {
                        $attachment = [
                            'id' => $attachment_id,
                            'url' => wp_get_attachment_url($attachment_id)
                        ];

                        $galleryData[] = $attachment['url'];
                        $gallery[] = $attachment;
                    }
                    ?>

                    <!-- POST GALLERY -->
                    <div class="post-gallery">
                        <!-- GALLERY POPUP BUTTON -->
                        <div id="post-open-gallery-popup-trigger" class="gallery-popup-button"
                             data-gallery="<?php echo esc_attr(json_encode($galleryData)); ?>">
                            <?php

                            /**
                             * Icon SVG
                             */
                            get_template_part('template-part/icon/icon', 'svg', [
                                'icon' => 'gallery'
                            ]);

                            ?>
                        </div>
                        <!-- /GALLERY POPUP BUTTON -->

                        <!-- POST GALLERY SLIDER -->
                        <div id="post-open-gallery-slider" class="post-gallery-slider swiper-container">
                            <div class="swiper-wrapper">
                                <?php foreach ($gallery as $galleryImage) : ?>
                                    <div class="post-gallery-slider-item swiper-slide"
                                         style="background: url('<?php echo esc_url($galleryImage['url']); ?>') center center / cover no-repeat;"></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- /POST GALLERY SLIDER -->

                        <!-- POST GALLERY CONTROLS -->
                        <div class="post-gallery-controls">
                            <!-- SLIDER CONTROL -->
                            <div id="post-open-gallery-control-prev" class="slider-control medium solid left">
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
                            <div id="post-open-gallery-control-next" class="slider-control medium solid right">
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
                        <!-- /POST GALLERY CONTROLS -->
                    </div>
                    <!-- /POST GALLERY -->
                <?php
                endif;
            else :
                ?>
                <!-- POST OPEN COVER -->
                <div class="post-open-cover"
                     style="<?php echo esc_attr('background: url(' . esc_url($args['post']['cover_url']) . ') center center / cover no-repeat'); ?>"></div>
                <!-- /POST OPEN COVER -->
            <?php
            endif;
            ?>

            <!-- POST OPEN BODY -->
            <div class="post-open-body">
                <!-- POST OPEN CONTENT -->
                <div class="post-open-content">
                    <!-- POST OPEN CONTENT BODY -->
                    <div class="post-open-content-body">
                        <?php if (isset($args['post']['excerpt'])): ?>
                            <!-- POST OPEN EXCERPT -->
                            <p class="post-open-excerpt"><?php echo esc_html($args['post']['excerpt']); ?></p>
                            <!-- /POST OPEN EXCERPT -->
                        <?php endif; ?>

                        <?php

                        wp_reset_postdata();

                        the_content();

                        wp_link_pages();

                        ?>

                        <?php
                        if (isset($args['post']['tags'])) {
                            /**
                             * Tag List
                             */
                            get_template_part('template-part/tag/tag', 'list', [
                                'tags' => $args['post']['tags']
                            ]);
                        }
                        ?>
                    </div>
                    <!-- /POST OPEN CONTENT BODY -->
                </div>
                <!-- /POST OPEN CONTENT -->

                <!-- COMMENT LIST -->
                <div id="comment-list" data-postid="<?php echo esc_attr($args['post']['id']); ?>"></div>
                <!-- /COMMENT LIST -->
            </div>
            <!-- /POST OPEN BODY -->
        </article>
        <!-- /POST OPEN -->
    </div>
    <!-- /GRID -->
</div>
<!-- /CONTENT GRID -->
