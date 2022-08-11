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

$sidemenu_status = get_theme_mod( 'yipnyap_sidemenu_setting_display', 'display' );
$header_version  = get_theme_mod( 'yipnyap_siteidentity_setting_header_type', 'v2' );

$has_custom_logo = has_custom_logo();

if ( $has_custom_logo ) {
	$logo_id  = get_theme_mod( 'custom_logo' );
	$logo_url = wp_get_attachment_image_src( $logo_id, 'full' );
} else {
	$logo_url = array( YIPNYAP_URL . '/img/yipnyap-logo.png' );
}

global $yipnyap_settings;

$display_search = ( $yipnyap_settings['search_status'] === 'display' ) && ( $yipnyap_settings['search_members_enabled'] || $yipnyap_settings['search_groups_enabled'] || $yipnyap_settings['search_blog_enabled'] );

if ( isset( $args['user'] ) ) {
	$display_verified = yipnyap_plugin_bpverifiedmember_is_active();

	$verified_user = $display_verified && $args['user']['verified'];
}

if ( $sidemenu_status === 'display' ) :
	?>
    <!-- NAVIGATION WIDGET -->
    <nav id="navigation-widget-small"
         style="margin-top: 0; z-index: 10001; padding-bottom: 0; left: 0;"
         class="cmui navigator navigation-widget navigation-widget-desktop navigation-widget-closed sidebar left hidden md:flex <?php echo $yipnyap_settings['sidemenu_active'] ? 'navigation-widget-hidden' : 'navigation-widget-delayed'; ?>">
        <a class="flex items-center justify-center" href="#">
            <img class="logo-image w-10 rounded"
                 src="<?php echo esc_url( $logo_url[0] ) ?>" alt="logo">
        </a>
        <div class="border-divider">
			<?php
			// show side menu items if it has at least one item
			if ( count( $args['side_menu_items'] ) > 0 ) {
				/**
				 * Menu
				 */
				get_template_part( 'template-part/navigation/menu', null, [
					'menu_items'    => $args['side_menu_items_flat'],
					'modifiers'     => 'small',
					'show_tooltips' => true
				] );
			}
			?>
        </div>
		<?php if ( isset( $args['user'] ) ) { ?>
            <div class="border-divider">
                <!-- SETTINGS -->
                <a class="cmui navigator-item <?php if ( str_contains( $_SERVER['REQUEST_URI'], "/settings" ) ) {
					echo esc_attr( 'active' );
				} ?>" href="<?php echo esc_url( $args['user']['link'] . '/settings' ) ?>">
                    <svg class="w-6 h-6 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </a>
            </div>
			<?php

			/**
			 * Avatar Small
			 */
			get_template_part( 'template-part/avatar/avatar', 'small', [
				'user'        => $args['user'],
				'linked'      => yipnyap_plugin_buddypress_is_active(),
				'no_border'   => true,
				'a_class'     => 'small no-border flex items-center justify-center w-16 h-16 user-avatar-circle big user-short-description-avatar mt-auto',
				'img_class'   => 'h-8 w-8 rounded-full',
                'cmui_nav'    => true
			] );

		}
		?>
    </nav>
    <!-- /NAVIGATION WIDGET -->
<?php

endif;

?>

<!-- NAVIGATION WIDGET -->
<nav id="navigation-widget-mobile"
     class="navigation-widget navigation-widget-mobile sidebar left navigation-widget-hidden" data-simplebar>
    <!-- NAVIGATION WIDGET CLOSE BUTTON -->
    <div class="navigation-widget-close-button">
		<?php

		/**
		 * Icon SVG
		 */
		get_template_part( 'template-part/icon/icon', 'svg', [
			'icon'      => 'back-arrow',
			'modifiers' => 'navigation-widget-close-button-icon'
		] );

		?>
    </div>
    <!-- /NAVIGATION WIDGET CLOSE BUTTON -->

	<?php if ( isset( $args['user'] ) ) { ?>
        <!-- NAVIGATION WIDGET INFO WRAP -->
        <div class="navigation-widget-info-wrap">
            <!-- NAVIGATION WIDGET INFO -->
            <div class="navigation-widget-info">
                <!-- USER AVATAR -->
				<?php

				/**
				 * Avatar Small
				 */
				get_template_part( 'template-part/avatar/avatar', 'small', [
					'user'      => $args['user'],
					'linked'    => yipnyap_plugin_buddypress_is_active(),
					'no_border' => true
				] );

				?>
                <!-- /USER AVATAR -->

                <!-- NAVIGATION WIDGET INFO TITLE -->
                <p class="navigation-widget-info-title">
					<?php

					echo esc_html( $args['user']['name'] );

					if ( $verified_user ) {
						echo $yipnyap_settings['bp_verified_member_badge'];
					}

					?>
                </p>
                <!-- /NAVIGATION WIDGET INFO TITLE -->

                <!-- NAVIGATION WIDGET INFO TEXT -->
                <p class="navigation-widget-info-text"><?php esc_html_e( 'Welcome Back!', 'yipnyap' ); ?></p>
                <!-- /NAVIGATION WIDGET INFO TEXT -->
            </div>
            <!-- /NAVIGATION WIDGET INFO -->

			<?php

			// add GamiPress points data if plugin is active
			if ( yipnyap_plugin_gamipress_is_active() ) {
				if ( count( $args['points'] ) ) {
					/**
					 * Point Item List
					 */
					get_template_part( 'template-part/point/point-item', 'list', [
						'points'    => $args['points'],
						'modifiers' => 'negative'
					] );
				}
			}

			?>

            <!-- NAVIGATION WIDGET BUTTON -->
            <a class="navigation-widget-info-button button small secondary"
               href="<?php echo esc_url( wp_logout_url( '/activity' ) ); ?>"><?php esc_html_e( 'Logout', 'yipnyap' ); ?></a>
            <!-- /NAVIGATION WIDGET BUTTON -->
        </div>
        <!-- /NAVIGATION WIDGET INFO WRAP -->
	<?php } ?>
	<?php if ( yipnyap_customizer_color_theme_switch_is_active() && isset( $args['user'] ) ) : ?>
        <!-- ACTION ITEM WRAP -->
        <div class="action-item-wrap">
            <!-- ACTION ITEM -->
            <div class="action-item hoverable vk-theme-toggle">
				<?php

				$color_theme = yipnyap_logged_user_color_theme_get();

				$toggle_color_theme = 'light';

				if ( $color_theme === 'light' ) {
					$toggle_color_theme = 'dark';
				}

				$color_theme_name = $color_theme === 'light' ? esc_html__( 'Switch to Dark', 'yipnyap' ) : esc_html__( 'Switch to Light', 'yipnyap' );

				/**
				 * Icon SVG
				 */
				get_template_part( 'template-part/icon/icon', 'svg', [
					'icon'      => $toggle_color_theme . '-theme',
					'modifiers' => 'action-item-icon'
				] );

				?>

                <!-- ACTION ITEM TEXT -->
                <p class="action-item-text"><?php echo esc_html( $color_theme_name ); ?></p>
                <!-- /ACTION ITEM TEXT -->
            </div>
            <!-- /ACTION ITEM -->
        </div>
        <!-- /ACTION ITEM WRAP -->
	<?php endif; ?>

	<?php if ( count( $args['side_menu_items'] ) > 0 ) : ?>
        <!-- NAVIGATION WIDGET SECTION -->
        <div class="navigation-widget-section">
            <!-- NAVIGATION WIDGET SECTION TITLE -->
            <p class="navigation-widget-section-title"><?php esc_html_e( 'Sections', 'yipnyap' ); ?></p>
            <!-- /NAVIGATION WIDGET SECTION TITLE -->

			<?php

			/**
			 * Menu
			 */
			get_template_part( 'template-part/navigation/menu', null, [
				'menu_items'      => $args['side_menu_items'],
				'show_menu_names' => true
			] );

			?>
        </div>
        <!-- /NAVIGATION WIDGET SECTION -->
	<?php endif; ?>

	<?php

	// show settings menu
	foreach ( $args['settings_navigation_sections'] as $settings_navigation_section ) {
		/**
		 * Navigation Widget Section
		 */
		get_template_part( 'template-part/navigation/navigation-widget-section', null, [
			'section_name'  => $settings_navigation_section['title'],
			'section_links' => $settings_navigation_section['menu_items']
		] );
	}

	// show header menu
	if ( count( $args['header_menu_items'] ) > 0 ) {
		$section_name = $args['header_menu_items'][0]['menu_name'];

		/**
		 * Navigation Widget Section
		 */
		get_template_part( 'template-part/navigation/navigation-widget-section', null, [
			'section_name'  => $section_name,
			'section_links' => $args['header_menu_items']
		] );
	}

	// show header features menu
	if ( count( $args['header_features_menu_items'] ) > 0 ) {
		foreach ( $args['header_features_menu_items'] as $header_features_menu_section => $header_features_menu_items ) {
			/**
			 * Navigation Widget Section
			 */
			get_template_part( 'template-part/navigation/navigation-widget-section', null, [
				'section_name'  => $header_features_menu_section,
				'section_links' => $header_features_menu_items
			] );
		}
	}
	?>
</nav>
<!-- /NAVIGATION WIDGET -->

<!-- HEADER -->
<header id="cmui-header" class="fixed top-0 w-full z-40"></header>
<!-- /HEADER -->
