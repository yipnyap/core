<?php
/**
 * Yipnyap Template Part - Header Logged In
 *
 * @param array $args {
 *
 * @type array $user User data.
 * @type array $points User points data.
 * @type array $side_menu_items Side menu items.
 * @type array $side_menu_items_flat Side menu items flattened.
 * @type array $header_menu_items Header menu items.
 * @type array $header_features_menu_items Header features menu items.
 * @type array $settings_navigation_sections Settings navigation sections.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see header.php
 *
 * @package Yipnyap
 */

$sidemenu_status = get_theme_mod('yipnyap_sidemenu_setting_display', 'display');
$header_version  = get_theme_mod('yipnyap_siteidentity_setting_header_type', 'v2');

global $yipnyap_settings;

$display_search = ($yipnyap_settings['search_status'] === 'display') && ($yipnyap_settings['search_members_enabled'] || $yipnyap_settings['search_groups_enabled'] || $yipnyap_settings['search_blog_enabled']);

if (isset($args['user'])) {
	$display_verified = yipnyap_plugin_bpverifiedmember_is_active();

	$verified_user = $display_verified && $args['user']['verified'];
}

if ($sidemenu_status === 'display') {
	?>
    <!-- NAVIGATION WIDGET -->
    <nav id="navigation-widget-small"
         style="z-index: 900; padding-bottom: 0;"
         class="cmui navigator border-divider navigation-widget navigation-widget-desktop hidden lg:flex <?php echo $yipnyap_settings['sidemenu_active'] ? 'hidden' : ''; ?>">
        <div class="section-divider">
			<?php
            if(isset($args['user'])) {
                /**
                 * Avatar Small
                 */
                get_template_part('template-part/avatar/avatar', 'small', [
                    'user'        => $args['user'],
                    'linked'      => yipnyap_plugin_buddypress_is_active(),
                    'no_border'   => true,
                    'hide_rank'   => true,
                    'a_class'     => 'cmui navigator-item mb-2 !mt-4',
                    'img_class'   => 'h-8 w-8 rounded-full',
                ]);
            }

			// show side menu items if it has at least one item
			if (count($args['side_menu_items']) > 0) {
				/**
				 * Menu
				 */
				get_template_part('template-part/navigation/menu', null, [
					'menu_items'    => $args['side_menu_items_flat'],
					'modifiers'     => 'small',
					'show_tooltips' => true
				]);
			}
			?>
        </div>
		<?php if(isset($args['user'])) { ?>
            <div class="mt-auto mb-4">
                <!-- SETTINGS -->
                <a class="cmui navigator-item <?php if (str_contains($_SERVER['REQUEST_URI'], "/settings")) {
					echo esc_attr('active');
				} ?>" href="<?php echo esc_url($args['user']['link'] . 'settings') ?>">
                    <?php
                    get_template_part( 'template-part/common/icon/icon', 'svg', [
                        'icon'      => 'cog-6-teeth',
                        'modifiers' => 'menu-item-link-icon w-6 h-6'
                    ]);
                    ?>
                </a>
            </div>
			<?php } ?>
    </nav>
    <!-- /NAVIGATION WIDGET -->
<?php } ?>
<!-- HEADER -->
<header id="cmui-header" class="bg-box border-solid border-0 border-b border-divider sticky top-0 w-full z-40" style="height: 64px;"></header>
<!-- /HEADER -->

<!-- CMUI Entire Content begin -->
<?php if (!isset($args['selfControlCMUI']) || $args['selfControlCMUI'] === false) { ?>
    <div id="cmui-entire-content" class="px-4 md:pl-24 pr-4 pt-4" style="overflow-y: auto; overflow-x: hidden;">
<?php } ?>
