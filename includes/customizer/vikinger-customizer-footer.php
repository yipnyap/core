<?php
/**
 * Yipnyap Customizer - Footer
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_footer($wp_customize) {
  /**
   * Footer Promo section
   */
  $wp_customize->add_section('yipnyap_footer', [
    'title'       => esc_html_x('Footer', '(Customizer) Footer Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can choose what\'s displayed on the left and bottom parts of the footer of the site. Please refer to the "Menus" section of this customizer if you want to edit the footer links.', '(Customizer) Footer Options - Description', 'yipnyap'),
    'priority'    => 300,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Footer Display
   */
  $wp_customize->add_setting('yipnyap_footer_setting_display', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'display'
  ]);

  $wp_customize->add_control('yipnyap_footer_control_display', [
    'label'       => esc_html_x('Display / Hide', '(Customizer) Footer Option - Display / Hide - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the footer.', '(Customizer) Footer Option - Display / Hide - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'display' => esc_html__('Display', 'yipnyap'),
      'hide'    => esc_html__('Hide', 'yipnyap')
    ],
    'section'     => 'yipnyap_footer',
    'settings'    => 'yipnyap_footer_setting_display',
  ]);

  /**
   * Navigation - Mobile Status
   */
  $wp_customize->add_setting('yipnyap_footer_setting_navigation_mobile_status', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'none'
  ]);

  $wp_customize->add_control('yipnyap_footer_control_navigation_mobile_status', [
    'label'       => esc_html_x('Navigation - Mobile Status', '(Customizer) Footer Option - Navigation - Mobile Status - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to display or hide the footer navigation on mobile resolutions.', '(Customizer) Footer Option - Navigation - Mobile Status - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'flex' => esc_html__('Display', 'yipnyap'),
      'none' => esc_html__('Hide', 'yipnyap')
    ],
    'section'     => 'yipnyap_footer',
    'settings'    => 'yipnyap_footer_setting_navigation_mobile_status',
  ]);

  /**
   * Promo Logo
   */
  $wp_customize->add_setting('yipnyap_footer_setting_promo_logo', [
    'sanitize_callback' => 'absint'
  ]);

  $wp_customize->add_control(new WP_Customize_Media_Control( $wp_customize, 'yipnyap_footer_control_promo_logo', [
    'label'     => esc_html_x('Promo - Logo', '(Customizer) Footer Option - Logo - Title', 'yipnyap'),
    'section'   => 'yipnyap_footer',
    'settings'  => 'yipnyap_footer_setting_promo_logo',
    'mime_type' => 'image'
  ]));

  /**
   * Promo Text
   */
  $wp_customize->add_setting('yipnyap_footer_setting_promo_text', [
    'sanitize_callback' => 'sanitize_text_field'
  ]);

  $wp_customize->add_control('yipnyap_footer_control_promo_text', [
    'label'     => esc_html_x('Promo - Text', '(Customizer) Footer Option - Text - Title', 'yipnyap'),
    'type'      => 'textarea',
    'section'   => 'yipnyap_footer',
    'settings'  => 'yipnyap_footer_setting_promo_text'
  ]);


  /**
   * Social Network Links
   */
  $footer_social_networks = [
    'facebook',
    'twitter',
    'instagram',
    'youtube',
    'twitch',
    'linkedin',
    'pinterest',
    'tiktok',
    'github',
    'reddit',
    'dribbble'
  ];

  foreach ($footer_social_networks as $social_network) {
    /**
     * Social Network Link
     */
    $wp_customize->add_setting('yipnyap_footer_setting_social_links[' . $social_network . ']', [
      'sanitize_callback' => 'esc_url_raw'
    ]);

    $wp_customize->add_control('yipnyap_footer_control_social_links_' . $social_network, [
      'label'     => esc_html_x('Social - ' . ucfirst($social_network) . ' Link', '(Customizer) Footer Option - ' . ucfirst($social_network) . ' Link - Title', 'yipnyap'),
      'type'      => 'text',
      'section'   => 'yipnyap_footer',
      'settings'  => 'yipnyap_footer_setting_social_links[' . $social_network . ']'
    ]);
  }

  /**
   * Bottom Left Text
   */
  $wp_customize->add_setting('yipnyap_footer_setting_bottom_left_text', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text'
  ]);

  $wp_customize->add_control('yipnyap_footer_control_bottom_left_text', [
    'label'     => esc_html_x('Bottom Left - Text', '(Customizer) Footer Option - Bottom Left Text - Title', 'yipnyap'),
    'type'      => 'text',
    'section'   => 'yipnyap_footer',
    'settings'  => 'yipnyap_footer_setting_bottom_left_text'
  ]);

  /**
   * Bottom Right Text
   */
  $wp_customize->add_setting('yipnyap_footer_setting_bottom_right_text', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text'
  ]);

  $wp_customize->add_control('yipnyap_footer_control_bottom_right_text', [
    'label'     => esc_html_x('Bottom Right - Text','(Customizer) Footer Option - Bottom Right Text - Title', 'yipnyap'),
    'type'      => 'text',
    'section'   => 'yipnyap_footer',
    'settings'  => 'yipnyap_footer_setting_bottom_right_text'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_footer');
