<?php
/**
 * Functions - WooCommerce - Filters
 * 
 * @package Yipnyap
 * 
 * @since 2022.05.2
 * 
 * @author Yipnyap (https://yipnyap.xyz/)
 * 
 */

/**
 * Allow customers to access wp-admin
 */
add_filter('woocommerce_prevent_admin_access', '__return_false');
add_filter('woocommerce_disable_admin_bar', '__return_false');

if (!function_exists('yipnyap_woocommerce_breadcrumb_defaults_filter')) {
  /**
   * Adds custom breadcrumb default options
   */
  function yipnyap_woocommerce_breadcrumb_defaults_filter($args) {
    $args['delimiter'] = '<span class="woocommerce-breadcrumb-separator">&#124;</span>';
  
    return $args;
  }
}

add_filter('woocommerce_breadcrumb_defaults', 'yipnyap_woocommerce_breadcrumb_defaults_filter');

if (!function_exists('yipnyap_woocommerce_dropdown_variation_attribute_options_html')) {
  /**
   * Adds SVG icon and wrapper to single product variation dropdowns
   */
  function yipnyap_woocommerce_dropdown_variation_attribute_options_html($html, $args) {
    ob_start();

    /**
     * Icon SVG
     */
    get_template_part('template-part/icon/icon', 'svg', [
      'icon'      => 'small-arrow',
      'modifiers' => 'form-select-icon'
    ]);

    $dropdownSVGIcon = ob_get_clean();

    $html = '<div class="form-select">' . $html . $dropdownSVGIcon . '</div>';

    return $html;
  }
}

add_filter('woocommerce_dropdown_variation_attribute_options_html', 'yipnyap_woocommerce_dropdown_variation_attribute_options_html', 10, 2);

if (!function_exists('yipnyap_woocommerce_quantity_input_classes')) {
  /**
   * Adds form counter input classes to quantity inputs
   */
  function yipnyap_woocommerce_quantity_input_classes($classes, $product) {
    $classes[] = 'vk-form-counter-input';

    return $classes;
  }
}

add_filter('woocommerce_quantity_input_classes', 'yipnyap_woocommerce_quantity_input_classes', 10, 2);

if (!function_exists('yipnyap_woocommerce_account_menu_items_filter')) {
  /**
   * Removes Dashboard and Logout options
   */
  function yipnyap_woocommerce_account_menu_items_filter($items, $endpoints) {
    unset($items['dashboard']);
    unset($items['customer-logout']);
  
    return $items;
  }
}

add_filter('woocommerce_account_menu_items', 'yipnyap_woocommerce_account_menu_items_filter', 10, 2);

if (!function_exists('yipnyap_woocommerce_minicart_fragments')) {
  /**
   * Handle mini cart AJAX updates
   */
  function yipnyap_woocommerce_minicart_fragments($fragments) {
    global $woocommerce;

    $cart_item_count = $woocommerce->cart->get_cart_contents_count();
    $cart_item_count_classes = $cart_item_count > 0 ? 'unread' : '';

    ob_start();

    ?>
    <div class="action-list-item-icon-wrap yipnyap-wc-cart-icon-wrap <?php echo esc_attr($cart_item_count_classes); ?>">
    <?php

      /**
       * Icon SVG
       */
      get_template_part('template-part/icon/icon', 'svg', [
        'icon'      => 'shopping-bag',
        'modifiers' => 'action-list-item-icon'
      ]);

    ?>
    </div>
    <?php

    $fragments['div.yipnyap-wc-cart-icon-wrap'] = ob_get_clean();

    ob_start();

    ?>
    <div class="dropdown-box-header yipnyap-wc-cart-header-title">
      <p class="dropdown-box-header-title"><?php esc_html_e('Shopping Cart', 'yipnyap'); ?> <span class="highlighted"><?php echo esc_html($cart_item_count); ?></span></p>
    </div>
    <?php

    $fragments['div.yipnyap-wc-cart-header-title'] = ob_get_clean();

    ob_start();

    ?>
    <div class="dropdown-box-list scroll-small yipnyap-wc-minicart" data-simplebar>
    <?php woocommerce_mini_cart(); ?>
    </div>
    <?php

    $fragments['div.yipnyap-wc-minicart'] = ob_get_clean();

    ob_start();

    ?>
    <div class="cart-preview-total yipnyap-wc-cart-preview-total">
      <p class="cart-preview-total-title"><?php esc_html_e('Total:', 'yipnyap'); ?></p>
      <p class="cart-preview-total-text"><?php echo $woocommerce->cart->get_cart_total(); ?></p>
    </div>
    <?php

    $fragments['div.yipnyap-wc-cart-preview-total'] = ob_get_clean();
      
    return $fragments;
  }
}

add_filter('woocommerce_add_to_cart_fragments', 'yipnyap_woocommerce_minicart_fragments');
