<?php
/**
 * Yipnyap Sidebars
 *
 * @since 1.0.0
 */

/**
 * Register sidebars
 */
function yipnyap_register_sidebars()
{
    register_sidebar(
        array(
            'id' => 'blog',
            'name' => esc_html_x('(Yipnyap) Blog Post Sidebar', '(Backend) Blog Post Sidebar - Title', 'yipnyap'),
            'description' => esc_html_x('A sidebar for blog posts', '(Backend) Blog Post Sidebar - Description', 'yipnyap'),
            'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<p class="widget-box-title">',
            'after_title' => '</p>'
        )
    );

    register_sidebar(
        array(
            'id' => 'blog_bottom',
            'name' => esc_html_x('(Yipnyap) Blog Post Bottom Sidebar', '(Backend) Blog Post Bottom Sidebar - Title', 'yipnyap'),
            'description' => esc_html_x('A bottom sidebar for blog posts', '(Backend) Blog Post Bottom Sidebar - Description', 'yipnyap'),
            'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<p class="widget-box-title">',
            'after_title' => '</p>'
        )
    );

    if (yipnyap_plugin_woocommerce_is_active()) {
        register_sidebar(
            array(
                'id' => 'shop',
                'name' => esc_html_x('(Yipnyap) WooCommerce Shop Sidebar', '(Backend) WooCommerce Shop Sidebar - Title', 'yipnyap'),
                'description' => esc_html_x('A sidebar for the WooCommerce shop page.', '(Backend) WooCommerce Shop Sidebar - Description', 'yipnyap'),
                'before_widget' => '<div id="%1$s" class="widget-box %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<p class="widget-box-title">',
                'after_title' => '</p>'
            )
        );
    }
}

add_action('widgets_init', 'yipnyap_register_sidebars');

?>
