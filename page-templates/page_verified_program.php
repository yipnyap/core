<?php
/**
 * Template Name: Verified Program page
 *
 * @package Yipnyap
 * @since hk15
 * @author Yipnyap (https://yipnyap.me/)
 */
require_once YIPNYAP_PATH . '/includes/functions/nextgen/UnicornEngine/index.php';

get_header();

$primaryAccent = UnicornGetPrimaryAccent(get_current_user_id(), '#FF80B5');

// header with breadcrumbs
get_template_part('template-part/common/header/header', null, [
    'title' => 'Verified Program',
    'icon' => 'grinning-cat-face-with-smiling-eyes',
    'beta' => true,
    'breadcrumbs' => [
        [
            'title' => 'Verified Program',
            'url' => get_permalink()
        ]
    ]
]);
?>

<main>
    <?php /* Hero */ ?>
    <section>
        <?php /* Top Accent Blurring */ ?>
        <div class="absolute inset-x-0 top-[-10rem] -z-10 transform-gpu overflow-hidden blur-3xl">
            <svg class="relative left-[calc(50%-11rem)] -z-10 h-[21.1875rem] max-w-none -translate-x-1/2 rotate-[30deg] sm:left-[calc(50%-30rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
                <defs>
                    <linearGradient id="45de2b6b-92d5-4d68-a6a0-9b9b2abad533" x1="1155.49" x2="-78.208" y1=".177" y2="474.645" gradientUnits="userSpaceOnUse">
                        <stop stop-color="#9089FC" offset="0"></stop>
                        <stop offset="1" stop-color="<?php echo $primaryAccent ?>"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </div>

        <?php /* Heading Text */ ?>
        <div class="text-primary pt-20 pb-32 sm:pt-48 sm:pb-40">
            <div class="max-w-3xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div class="mx-auto space-y-8 lg:max-w-none">
                    <p class="text-3xl font-extrabold sm:text-4xl lg:text-5xl">
                        Verified Program for those who do great
                    </p>
                    <p class="text-xl text-neutral-500">
                        Make amazing stuff? Worried about being impersonated? Don't want to give
                        twitter $8? Yipnyap has a free Verified Program that gives you a badge
                        and extra perks while using Yipnyap, similar to a partner program.
                    </p>
                    <div class="flex gap-x-4 sm:justify-center">
                        <a href="https://yipnyap.atlassian.net/servicedesk/customer/portal/3/group/11/create/65"
                           class="inline-block ypsdk button-upgrade shadow-sm" color="primary">
                            Get started
                            <span class="text-indigo-200" aria-hidden="true">&rarr;</span>
                        </a>
                        <!--                        <a href="#" class="inline-block rounded-xl px-4 py-1.5 text-base font-semibold leading-7 text-primary ring-1 ring-gray-900/10 hover:ring-gray-900/20">-->
                        <!--                            Learn more-->
                        <!--                            <span class="text-neutral-400" aria-hidden="true">&rarr;</span>-->
                        <!--                        </a>-->
                    </div>
                </div>
            </div>
        </div>

        <?php /* Bottom Accent Blurring */ ?>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
            <svg class="relative left-[calc(50%+3rem)] h-[21.1875rem] max-w-none -translate-x-1/2 sm:left-[calc(50%+36rem)] sm:h-[42.375rem]" viewBox="0 0 1155 678" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="url(#45de2b6b-92d5-4d68-a6a0-9b9b2abad533)" fill-opacity=".3" d="M317.219 518.975L203.852 678 0 438.341l317.219 80.634 204.172-286.402c1.307 132.337 45.083 346.658 209.733 145.248C936.936 126.058 882.053-94.234 1031.02 41.331c119.18 108.451 130.68 295.337 121.53 375.223L855 299l21.173 362.054-558.954-142.079z" />
            </svg>
        </div>
    </section>

    <?php /* Body */ ?>
    <section>

    </section>
</main>

<?php get_footer(); ?>
