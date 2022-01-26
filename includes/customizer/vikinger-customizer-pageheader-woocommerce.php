<?php
/**
 * Yipnyap Customizer - WooCommerce Page Header
 *
 * @since 1.0.0
 */

function yipnyap_customizer_pageheader_woocommerce($wp_customize)
{
    /**
     * WooCommerce Header section
     */
    $wp_customize->add_section('yipnyap_pageheader_woocommerce', [
        'title' => esc_html_x('Page Headers - WooCommerce', '(Customizer) Page Headers WooCommerce Options - Title', 'yipnyap'),
        'description' => esc_html_x('From here, you can customize the woocommerce page headers.', '(Customizer) Page Headers WooCommerce Options - Description', 'yipnyap'),
        'priority' => 290,
        'panel' => 'yipnyap_customizer'
    ]);

    /**
     * WooCommerce Header Image
     */
    $wp_customize->add_setting('yipnyap_pageheader_woocommerce_setting_image', [
        'sanitize_callback' => 'absint'
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'yipnyap_pageheader_woocommerce_control_image', [
        'label' => esc_html_x('WooCommerce Page Header - Image', '(Customizer) WooCommerce Page Header Image - Title', 'yipnyap'),
        'description' => esc_html_x('Image of the woocommerce page headers.', '(Customizer) WooCommerce Page Header Image - Description', 'yipnyap'),
        'section' => 'yipnyap_pageheader_woocommerce',
        'settings' => 'yipnyap_pageheader_woocommerce_setting_image',
        'mime_type' => 'image'
    ]));

    /**
     * WooCommerce Header Title
     */
    $wp_customize->add_setting('yipnyap_pageheader_woocommerce_setting_title', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => esc_html_x('Yipnyap Shop', 'WooCommerce Page - Title', 'yipnyap')
    ]);

    $wp_customize->add_control('yipnyap_pageheader_woocommerce_control_title', [
        'label' => esc_html_x('WooCommerce Page Header - Title', '(Customizer) WooCommerce Page Header Title - Title', 'yipnyap'),
        'description' => esc_html_x('Title of the woocommerce page headers.', '(Customizer) WooCommerce Page Header Title - Description', 'yipnyap'),
        'type' => 'text',
        'section' => 'yipnyap_pageheader_woocommerce',
        'settings' => 'yipnyap_pageheader_woocommerce_setting_title'
    ]);

    /**
     * WooCommerce Header Description
     */
    $wp_customize->add_setting('yipnyap_pageheader_woocommerce_setting_description', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => esc_html_x('Merchandise, clothing, coffee mugs and more!', 'WooCommerce Page - Description', 'yipnyap')
    ]);

    $wp_customize->add_control('yipnyap_pageheader_woocommerce_control_description', [
        'label' => esc_html_x('WooCommerce Page Header - Description', '(Customizer) WooCommerce Page Header Description - Title', 'yipnyap'),
        'description' => esc_html_x('Description of the woocommerce page headers.', '(Customizer) WooCommerce Page Header Description - Description', 'yipnyap'),
        'type' => 'textarea',
        'section' => 'yipnyap_pageheader_woocommerce',
        'settings' => 'yipnyap_pageheader_woocommerce_setting_description'
    ]);
}

add_action('customize_register', 'yipnyap_customizer_pageheader_woocommerce');
