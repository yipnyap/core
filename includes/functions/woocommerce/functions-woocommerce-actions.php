<?php
/**
 * Functions - WooCommerce - Actions
 *
 * @package Yipnyap
 *
 * @since 2022.05.2
 *
 * @author Yipnyap (https://yipnyap.xyz/)
 *
 */

/**
 * Remove WooCommerce default wrappers
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Remove default gravatar from review comment
 */
remove_action('woocommerce_review_before', 'woocommerce_review_display_gravatar');

/**
 * Remove mini cart "view cart" button
 */
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart');

/**
 * Remove mini cart "checkout" button
 */
remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

/**
 * Remove mini cart sub total
 */
remove_action('woocommerce_widget_shopping_cart_total', 'woocommerce_widget_shopping_cart_subtotal');

if (!function_exists('yipnyap_woocommerce_wrapper_start')) {
  /**
   * Adds custom wrapper start for WooCommerce pages
   */
  function yipnyap_woocommerce_wrapper_start() {
  ?>
  <!-- CONTENT GRID -->
  <div class="content-grid">
  <?php

    $shop_sidebar_is_active = is_active_sidebar('shop');
    $shop_sidebar_active_class = $shop_sidebar_is_active ? 'yipnyap-wc-content-with-sidebar' : '';

  ?>

    <!-- YIPNYAP WC CONTENT -->
    <div class="yipnyap-wc-content <?php echo esc_attr($shop_sidebar_active_class); ?>">
      <!-- YIPNYAP WC BODY -->
      <div class="yipnyap-wc-body">
  <?php
  }
}

add_action('woocommerce_before_main_content', 'yipnyap_woocommerce_wrapper_start', 10);

if (!function_exists('yipnyap_woocommerce_after_main_content')) {
  /**
   * Adds custom wrapper end for WooCommerce pages
   */
  function yipnyap_woocommerce_after_main_content() {
  ?>
      </div>
      <!-- /YIPNYAP WC BODY -->

      <!-- YIPNYAP WC SIDEBAR -->
      <div class="yipnyap-wc-sidebar">
  <?php
  }
}

add_action('woocommerce_after_main_content', 'yipnyap_woocommerce_after_main_content', 10);

if (!function_exists('yipnyap_woocommerce_wrapper_end')) {
  /**
   * Adds custom wrapper end for WooCommerce pages
   */
  function yipnyap_woocommerce_wrapper_end() {
  ?>
      </div>
      <!-- YIPNYAP WC SIDEBAR -->
    </div>
    <!-- YIPNYAP WC CONTENT -->
  </div>
  <!-- /CONTENT GRID -->
  <?php
  }
}

add_action('woocommerce_sidebar', 'yipnyap_woocommerce_wrapper_end', 10);

if (!function_exists('yipnyap_woocommerce_before_shop_loop_item_title')) {
  /**
   * Adds custom loop product item wrapper before title
   */
  function yipnyap_woocommerce_before_shop_loop_item_title() {
  ?>
  <!-- YIPNYAP WC PRODUCT INFO -->
  <div class="yipnyap-wc-product-info">
  <?php
  }
}

add_action('woocommerce_before_shop_loop_item_title', 'yipnyap_woocommerce_before_shop_loop_item_title', 20);

if (!function_exists('yipnyap_woocommerce_after_shop_loop_item_title_categories')) {
  /**
   * Adds custom loop product item categories
   */
  function yipnyap_woocommerce_after_shop_loop_item_title_categories() {
    global $product;

    $product_categories_text = '';

		if ($product) {
      $category_ids = $product->get_category_ids();

      if (count($category_ids) > 0) {
        $product_categories_text = wc_get_product_category_list($product->get_id());
      }
    }

    if ($product_categories_text) :
  ?>
  <!-- YIPNYAP WP CATEGORIES -->
  <p class="yipnyap-wc-categories"><?php echo $product_categories_text; ?></p>
  <!-- /YIPNYAP WP CATEGORIES -->
  <?php
    endif;
  }
}

add_action('woocommerce_after_shop_loop_item_title', 'yipnyap_woocommerce_after_shop_loop_item_title_categories', 2);

if (!function_exists('yipnyap_woocommerce_after_shop_loop_item_title')) {
  /**
   * Adds custom loop product item wrapper after title
   */
  function yipnyap_woocommerce_after_shop_loop_item_title() {
  ?>
  </div>
  <!-- /YIPNYAP WC PRODUCT INFO -->
  <?php
  }
}

add_action('woocommerce_after_shop_loop_item_title', 'yipnyap_woocommerce_after_shop_loop_item_title', 20);

if (!function_exists('yipnyap_woocommerce_product_loop_item_before_buttons')) {
  function yipnyap_woocommerce_product_loop_item_before_buttons() {
  ?>
  <!-- YIPNYAP WOOCOMMERCE PRODUCT ACTIONS -->
  <div class="yipnyap-woocommerce-product-actions">
  <?php
  }
}

add_action('woocommerce_after_shop_loop_item', 'yipnyap_woocommerce_product_loop_item_before_buttons', 9);

if (!function_exists('yipnyap_woocommerce_product_loop_item_after_buttons')) {
  function yipnyap_woocommerce_product_loop_item_after_buttons() {
  ?>
  </div>
  <!-- /YIPNYAP WOOCOMMERCE PRODUCT ACTIONS -->
  <?php
  }
}

add_action('woocommerce_after_shop_loop_item', 'yipnyap_woocommerce_product_loop_item_after_buttons', 11);

if (!function_exists('yipnyap_woocommerce_single_product_summary_categories')) {
  function yipnyap_woocommerce_single_product_summary_categories() {
    global $product;

    $product_categories_text = '';

		if ($product) {
      $category_ids = $product->get_category_ids();

      if (count($category_ids) > 0) {
        $product_categories_text = wc_get_product_category_list($product->get_id());
      }
    }

    if ($product_categories_text) :
    ?>
    <!-- YIPNYAP WP CATEGORIES -->
    <p class="yipnyap-wc-categories"><?php echo $product_categories_text; ?></p>
    <!-- /YIPNYAP WP CATEGORIES -->
    <?php
    endif;
  }
}

add_action('woocommerce_single_product_summary', 'yipnyap_woocommerce_single_product_summary_categories', 9);

if (!function_exists('yipnyap_woocommerce_review_before_avatar')) {
  /**
   * Adds custom avatar to review comments
   */
  function yipnyap_woocommerce_review_before_avatar($comment) {
    $review_author = yipnyap_members_get_fallback((int) $comment->user_id);

    /**
     * Avatar Small
     */
    get_template_part('template-part/avatar/avatar', 'small', [
      'user'      => $review_author,
      'modifiers' => 'comment-review-avatar',
      'linked'    => true,
      'no_border' => true
    ]);
  }
}

add_action('woocommerce_review_before', 'yipnyap_woocommerce_review_before_avatar', 10, 1);

if (!function_exists('yipnyap_woocommerce_redirect_myaccount_root_to_orders')) {
  /**
   * Redirect users when accessing my-account root page (dashboard)
   * to the orders page
   */
  function yipnyap_woocommerce_redirect_myaccount_root_to_orders() {
    if (yipnyap_plugin_woocommerce_is_active()) {
      global $woocommerce;

      $current_woocommerce_endpoint = $woocommerce->query->get_current_endpoint();

      // on my-account root page
      if (is_account_page() && empty($current_woocommerce_endpoint)){
        wp_safe_redirect(wc_get_account_endpoint_url('orders'));
        exit;
      }
    }
  }
}

add_action('template_redirect', 'yipnyap_woocommerce_redirect_myaccount_root_to_orders', 10);

if (!function_exists('yipnyap_woocommerce_account_content_before')) {
  /**
   * Adds section header before the content in the account pages
   */
  function yipnyap_woocommerce_account_content_before() {

    $section_pretitle = get_the_title();

    global $wp;

    foreach ( $wp->query_vars as $key => $value ) {
      // Ignore pagename param.
      if ( 'pagename' === $key ) {
        continue;
      }

      $wc_endpoint = $key;

      // root myaccount page
      if ($key === 'page') {
        $wc_endpoint = 'dashboard';
      }
    }

    $section_title = false;

    $wc_myaccount_menu_items = wc_get_account_menu_items();

    if (array_key_exists($wc_endpoint, $wc_myaccount_menu_items)) {
      $section_title = $wc_myaccount_menu_items[$wc_endpoint];
    }

    if ($section_title) {
      /**
       * Section Header
       */
      get_template_part('template-part/section/section', 'header', [
        'section_pretitle'  => $section_pretitle,
        'section_title'     => $section_title
      ]);
    }
  }
}

add_action('woocommerce_account_content', 'yipnyap_woocommerce_account_content_before', 5);
