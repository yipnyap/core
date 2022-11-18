<?php
/**
 * Yipnyap Template Part - Menu
 *
 * @param array $args {
 *
 * @type array $menu_items Menu items data.
 * @type string $modifiers Optional. Additional class names to add to the HTML wrapper.
 * @type bool $show_tooltips Optional. Displays tooltips when hovering over the menu items if set.
 * @type bool $show_menu_names Optional. Displays menu name text.
 * }
 * @since 1.0.0
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 * @see yipnyap_menu_get_items
 *
 * @package Yipnyap
 */

$modifiers       = isset( $args['modifiers'] ) ? $args['modifiers'] : false;
$show_tooltips   = isset( $args['show_tooltips'] ) ? $args['show_tooltips'] : false;
$show_menu_names = isset( $args['show_menu_names'] ) ? $args['show_menu_names'] : false;

$modifiers_classes      = $modifiers ? $modifiers : '';
$menu_item_link_classes = $show_tooltips ? 'text-tooltip-tfr' : '';

?>

<!-- MENU -->
<?php

foreach ( $args['menu_items'] as $menu_item ) :
	$menu_item_classes = $menu_item['active'] ? 'cmui active' : '';

	?>
    <!-- MENU ITEM LINK -->
    <a class="cmui navigator-item <?php echo esc_attr( $menu_item_classes ); ?> <?php echo esc_attr( $menu_item_link_classes ); ?>"
       href="<?php echo esc_url( $menu_item['link'] ); ?>"
		<?php echo $menu_item['target'] !== '' ? 'target="' . $menu_item['target'] . '"' : ''; ?>
       title="<?php echo esc_attr( $menu_item['name'] ); ?>"
    >
		<?php

		/**
		 * Icon SVG
		 */
		get_template_part( 'template-part/common/icon/icon', 'svg', [
			'icon'      => $menu_item['icon'],
			'modifiers' => 'menu-item-link-icon w-6 h-6'
		]);


		if ( $show_menu_names ) {
			echo esc_html( $menu_item['name'] );
		}

		?>
    </a>
    <!-- /MENU ITEM LINK -->

	<?php

	if ( count( $menu_item['children'] ) > 0 ) {
		/**
		 * Menu
		 */
		get_template_part( 'template-part/navigation/menu', null, [
			'menu_items'      => $menu_item['children'],
			'modifiers'       => $modifiers,
			'show_tooltips'   => $show_tooltips,
			'show_menu_names' => $show_menu_names
		] );
	}

	?>
<?php endforeach; ?>
<!-- /MENU -->
