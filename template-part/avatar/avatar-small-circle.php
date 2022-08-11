<?php
/**
 * Yipnyap Template Part - Avatar Small Circle
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

$modifiers = $args['modifiers'] ?? false;
$no_border = $args['no_border'] ?? false;
$linked = $args['linked'] ?? false;
$a_class = $args['a_class'] ?? false;
$img_class = $args['img_class'] ?? false;
$is_cmui_nav = $args['cmui_nav'] ?? false;
$no_stats = !array_key_exists('rank', $args['user']);

$modifiers_classes = $modifiers ? $modifiers : '';
$no_border_classes = $no_border ? 'no-border' : '';
$no_stats_classes = $no_stats ? 'no-stats' : '';

$current_rank = 1;
$max_rank = 1;

if (!$no_stats) {
    $current_rank = (int)$args['user']['rank']['current'];
    $max_rank = (int)$args['user']['rank']['total'];

    $current_rank_ratio = $current_rank / $max_rank;
}

?>

<!-- USER AVATAR CIRCLE -->
<?php if ($linked) : ?>
<a class="<?php if ($a_class) { echo esc_attr($a_class); } else { ?> user-avatar-circle small <?php echo esc_attr($no_stats_classes); ?> <?php echo esc_attr($modifiers_classes); ?> <?php echo esc_attr($no_border_classes); } ?>"
   href="<?php echo esc_url($args['user']['link']) ?>" style="<?php if ($is_cmui_nav) echo 'margin-top: auto !important; margin-bottom: 1em;' ?>">
    <?php else : ?>
    <div class="user-avatar-circle small <?php echo esc_attr($no_stats_classes); ?> <?php echo esc_attr($modifiers_classes); ?> <?php echo esc_attr($no_border_classes); ?>">
        <?php endif; ?>
        <!-- USER AVATAR CIRCLE IMAGE -->
        <img class="<?php if ($img_class) { echo esc_attr($img_class); } else { ?> user-avatar-circle-image <?php } ?>" src="<?php echo esc_url($args['user']['avatar_url']); ?>"
             alt="avatar-image">
        <!-- /USER AVATAR CIRCLE IMAGE -->

        <?php if (!$no_stats) : ?>
            <!-- USER AVATAR CIRCLE PROGRESS -->
            <div class="user-avatar-circle-progress user-avatar-circle-progress-small"
                 data-scalestop="<?php echo esc_attr($current_rank_ratio); ?>"></div>
            <!-- /USER AVATAR CIRCLE PROGRESS -->

            <!-- USER AVATAR CIRCLE BADGE -->
            <div class="user-avatar-circle-badge">
                <!-- USER AVATAR CIRCLE BADGE CONTENT -->
                <div class="user-avatar-circle-badge-content">
                    <!-- USER AVATAR CIRCLE BADGE CONTENT TEXT -->
                    <p class="user-avatar-circle-badge-content-text"><?php echo esc_html($args['user']['rank']['current']); ?></p>
                    <!-- /USER AVATAR CIRCLE BADGE CONTENT TEXT -->
                </div>
                <!-- /USER AVATAR CIRCLE BADGE CONTENT -->
            </div>
            <!-- /USER AVATAR CIRCLE BADGE -->
        <?php endif; ?>

        <?php if ($linked) : ?>
</a>
<?php else : ?>
    </div>
<?php endif; ?>
<!-- /USER AVATAR CIRCLE -->
