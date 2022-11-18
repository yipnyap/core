<?php
/**
 * Template Name: Market Page
 *
 * @package Yipnyap
 * @since hk14
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

// check if achievement unlock is submitted
$achievement_unlock_submitted = isset($_POST['achievement_unlock']);

// if achievement unlock submitted
if ($achievement_unlock_submitted) {
    $achievement_unlock_id = absint($_POST['achievement_unlock_id']);
    $achievement_unlocked = yipnyap_gamipress_unlock_logged_user_achievement_with_points($achievement_unlock_id);

    // Redirect to same page to avoid form resubmission
    /** @noinspection PhpUndefinedVariableInspection */
    $redirect_url = esc_url(home_url($wp->request));
    wp_safe_redirect($redirect_url);
    exit;
}

$userID = get_current_user_id();
$userEarnings = yipnyap_gamipress_get_logged_user_points() ?? [];
$marketItems = yipnyap_gamipress_get_achievements(['post_type' => 'market-item'], $userID) ?? [];

get_header();

$type = 'market-item';

get_template_part('template-part/common/header/header', '', [
    'title' => 'Market',
    'icon' => 'money-with-wings',
    'beta' => true,
    'breadcrumbs' => [
        [
            'title' => 'Credits',
            'url' => '/credits',
        ],
        [
            'title' => 'Market',
            'url' => '/market',
        ],
    ],
]);
?>
<main>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div>
                <?php if (isset($userEarnings['gold'])) { ?>
                <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div class="px-4 py-5 bg-box shadow rounded-xl overflow-hidden sm:p-6">
                        <dt class="text-sm font-medium text-alt truncate">Your Credits</dt>
                        <dd class="mt-1 text-3xl font-semibold text-primary"><?php echo $userEarnings['gold']['points'] ?></dd>
                    </div>

                    <div class="px-4 py-5 bg-box shadow rounded-xl overflow-hidden sm:p-6">
                        <dt class="text-sm font-medium text-alt truncate">Items Available</dt>
                        <dd class="mt-1 text-3xl font-semibold text-primary"><?php echo count($marketItems) ?></dd>
                    </div>
                </dl>
                <?php } ?>

                <div class="mt-5 px-4 py-5 bg-box shadow rounded-xl overflow-hidden sm:p-6" style="min-height: 106px;">
                    <dt class="text-sm font-medium text-alt truncate mb-2"><img class="pixelmoji w-6 h-6" src="<?php echo YIPNYAP_URL . '/img/emoji/heavy-exclamation-mark-symbol.gif' ?>" alt="Heavy exclamation mark emoji"> Note about Yipnyap Market</dt>
                    <dd class="mt-1 text-primary">
                        Yipnyap Market is a place where you can spend you credits <img class="pixelmoji w-6 h-6" src="<?php echo YIPNYAP_URL . '/img/emoji/sparkles.gif' ?>" alt="Sparkles animated emoji"><br>
                        it's using experimental UI & features, so please be patient if something doesn't work or look as expected!
                    </dd>
                </div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php

                $achievement_args = [
                    'user_points' => $userEarnings,
                    'achievement_complete_info' => true
                ];

                $achievement_args['achievement_image_wrap'] = true;

                foreach ($marketItems as $item) {
                    $achievement_args['achievement'] = $item;

                    /**
                     * Achievement Item Box
                     */
                    get_template_part('template-part/achievement/achievement', 'item-box', $achievement_args);
                }

                ?>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
