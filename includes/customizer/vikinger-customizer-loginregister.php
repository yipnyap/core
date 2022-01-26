<?php
/**
 * Yipnyap Customizer - Login Register
 *
 * @since 1.0.0
 */

function yipnyap_customizer_loginregister($wp_customize)
{
    /**
     * Login Register Page section
     */
    $wp_customize->add_section('yipnyap_loginregister', [
        'title' => esc_html_x('Login - Register', '(Customizer) Login - Register Options - Title', 'yipnyap'),
        'description' => esc_html_x('From here, you can customize the login and register page options.', '(Customizer) Login - Register Options - Description', 'yipnyap'),
        'priority' => 20,
        'panel' => 'yipnyap_customizer'
    ]);

    /**
     * Login Register Display
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_forcelogin', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => 'disabled'
    ]);

    $wp_customize->add_control('yipnyap_loginregister_control_forcelogin', [
        'label' => esc_html_x('Force Login', '(Customizer) Force Login Option - Display / Hide - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose to force non admin users to have to be logged in in order to be able to browse your site pages (will redirect users to the login page).', '(Customizer) Force Login Option - Display / Hide - Description', 'yipnyap'),
        'type' => 'radio',
        'choices' => [
            'enabled' => esc_html__('Enabled', 'yipnyap'),
            'disabled' => esc_html__('Disabled', 'yipnyap')
        ],
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_forcelogin',
    ]);

    /**
     * Login Register Redirect
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_redirect', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => ''
    ]);

    $wp_customize->add_control('yipnyap_loginregister_control_redirect', [
        'label' => esc_html_x('Login - Redirect Page', '(Customizer) Login Option - Redirect Page - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose which page users are redirected to when they login to the site (home page is used by default).', '(Customizer) Login Option - Redirect Page - Description', 'yipnyap'),
        'type' => 'dropdown-pages',
        'allow_addition' => false,
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_redirect',
    ]);

    /**
     * Login Register Exceptions
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_exceptions', [
        'sanitize_callback' => 'yipnyap_customizer_sanitize_array',
        'default' => []
    ]);

    $wp_customize->add_control(new WP_VK_MultiSelect_Control($wp_customize, 'yipnyap_loginregister_control_exceptions', [
        'label' => esc_html_x('Force Login - Exceptions', '(Customizer) Force Login Option - Exceptions - Title', 'yipnyap'),
        'description' => esc_html_x('You can choose pages that can still be accessible when the force login option is enabled.', '(Customizer) Force Login Option - Exceptions - Description', 'yipnyap'),
        'type' => 'vk_multiselect',
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_exceptions',
    ]));

    /**
     * Login Page Logo
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_login_logo', [
        'sanitize_callback' => 'absint'
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'yipnyap_loginregister_control_login_logo', [
        'label' => esc_html_x('Login Page Logo', '(Customizer) Login Page Logo - Title', 'yipnyap'),
        'description' => esc_html_x('The logo that displays above the form of the login page.', '(Customizer) Login Page Logo - Description', 'yipnyap'),
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_login_logo',
        'mime_type' => 'image'
    ]));

    /**
     * Login Page Background
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_login_background', [
        'sanitize_callback' => 'absint'
    ]);

    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'yipnyap_loginregister_control_login_background', [
        'label' => esc_html_x('Login Page Background', '(Customizer) Login Page Background - Title', 'yipnyap'),
        'description' => esc_html_x('The background image of the login page.', '(Customizer) Login Page Background - Description', 'yipnyap'),
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_login_background',
        'mime_type' => 'image'
    ]));

    /**
     * Login Page Pre Title
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_login_pretitle', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => esc_html_x('Welcome to', 'Login Page - Pre Title', 'yipnyap')
    ]);

    $wp_customize->add_control('yipnyap_loginregister_control_login_pretitle', [
        'label' => esc_html_x('Login Page - Pre Title', '(Customizer) Login Page Pre Title - Title', 'yipnyap'),
        'description' => esc_html_x('The text that displays before the title of the login page.', '(Customizer) Login Page Pre Title - Description', 'yipnyap'),
        'type' => 'text',
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_login_pretitle'
    ]);

    /**
     * Login Page Title
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_login_title', [
        'sanitize_callback' => 'sanitize_text_field',
        'default' => esc_html_x('Yipnyap', 'Login Page - Title', 'yipnyap')
    ]);

    $wp_customize->add_control('yipnyap_loginregister_control_login_title', [
        'label' => esc_html_x('Login Page - Title', '(Customizer) Login Page Title - Title', 'yipnyap'),
        'description' => esc_html_x('The title of the login page.', '(Customizer) Login Page Title - Description', 'yipnyap'),
        'type' => 'text',
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_login_title'
    ]);

    /**
     * Login Page Text
     */
    $wp_customize->add_setting('yipnyap_loginregister_setting_login_text', [
        'sanitize_callback' => 'yipnyap_customizer_sanitize_text',
        'default' => sprintf(esc_html__('%sThe next generation WordPress+Buddypress social community!%s Connect with your friends with full profiles, reactions, groups, badges, quests, ranks, credits and %smuch more to come!%s', 'yipnyap'), '<span class="bold">', '</span>', '<span class="bold">', '</span>')
    ]);

    $wp_customize->add_control('yipnyap_loginregister_control_login_text', [
        'label' => esc_html_x('Login Page - Text', '(Customizer) Login Page Title - Text', 'yipnyap'),
        'description' => esc_html_x('The text of the login page.', '(Customizer) Login Page Text - Description', 'yipnyap'),
        'type' => 'textarea',
        'section' => 'yipnyap_loginregister',
        'settings' => 'yipnyap_loginregister_setting_login_text'
    ]);
}

add_action('customize_register', 'yipnyap_customizer_loginregister');
