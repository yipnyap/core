<?php
/**
 * Yipnyap Template - Footer
 *
 * @package Yipnyap
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

// footer status
$footer_status = get_theme_mod('yipnyap_footer_setting_display', 'display');

$buddypress_plugin_is_active = yipnyap_plugin_buddypress_is_active();

$display_footer = ($footer_status === 'display') && (($buddypress_plugin_is_active && !bp_is_register_page() && !bp_is_activation_page()) || !$buddypress_plugin_is_active);

if ($display_footer) :
    // floating banner settings (currently only for user registration notices)
    // TODO: Make this configurable to be anything on the fly!
    $floating_banner_show = get_option('users_can_register') === '0';
    $floating_banner_can_dismiss = false;
    $floating_banner_learn_more = false;
    $floating_banner_brief_heading = 'Registration is disabled!';
    $floating_banner_text = $floating_banner_brief_heading . ' New users can\'t make accounts.';

    ?>

    <!-- FLOATING BANNER NOTICE -->
    <?php if ($floating_banner_show) { ?>
    <div class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="p-2 rounded-xl bg-indigo-600 shadow-lg sm:p-3">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 flex items-center">
          <span class="flex p-2 rounded-xl bg-indigo-800">
            <!-- Heroicon name: outline/speakerphone -->
            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
          </span>
                        <p class="ml-3 font-medium text-white">
                            <span class="md:hidden"> <?php echo $floating_banner_brief_heading ?> </span>
                            <span class="hidden md:inline"> <?php echo $floating_banner_text ?> </span>
                        </p>
                    </div>

                    <?php if ($floating_banner_learn_more) { ?>
                        <div class="order-3 mt-2 flex-shrink-0 w-full sm:order-2 sm:mt-0 sm:w-auto">
                            <a href="#" class="flex items-center justify-center px-4 py-2 border border-transparent rounded-default shadow-sm text-sm font-medium text-indigo-600 bg-white hover:bg-indigo-50"> Learn more </a>
                        </div>
                    <?php } ?>

                    <?php if ($floating_banner_can_dismiss) { ?>
                        <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-2">
                            <button type="button" class="-mr-1 flex p-2 rounded-default hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-white">
                                <span class="sr-only">Dismiss</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<footer class="footer-wrap"></footer>
<?php

endif;

?>

<?php wp_footer(); ?>
<!-- CMUI Entire Content End -->
<!--</div>-->
</body>
</html>
