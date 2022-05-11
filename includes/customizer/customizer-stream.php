<?php
/**
 * Yipnyap Customizer - Stream
 * 
 * @since 2022.05.2
 */

function yipnyap_customizer_stream($wp_customize) {
  /**
   * Stream section
   */
  $wp_customize->add_section('yipnyap_stream', [
    'title'       => esc_html_x('Stream', '(Customizer) Stream - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change stream related options.', '(Customizer) Stream - Description', 'yipnyap'),
    'priority'    => 285,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Stream Profile Status
   */
  $wp_customize->add_setting('yipnyap_stream_setting_profile_status', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'enabled'
  ]);

  $wp_customize->add_control('yipnyap_stream_control_profile_status', [
    'label'       => esc_html_x('Stream Profile - Status', '(Customizer) Stream Profile Option - Status - Title', 'yipnyap'),
    'description' => esc_html_x('You can choose to enable or disable stream profile functionality (disabling this will remove the profile activity widget, profile activity page and account hub settings page).', '(Customizer) Stream Profile Option - Status - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'enabled'   => esc_html__('Enabled', 'yipnyap'),
      'disabled'  => esc_html__('Disabled', 'yipnyap')
    ],
    'section'     => 'yipnyap_stream',
    'settings'    => 'yipnyap_stream_setting_profile_status',
  ]);

  /**
   * Twitch Embeds Parent Domain
   */
  $wp_customize->add_setting('yipnyap_stream_setting_twitch_embed_parent', [
    'sanitize_callback' => 'yipnyap_customizer_sanitize_text_comma_separated',
    'default'           => 'yipnyap.xyz'
  ]);

  $wp_customize->add_control('yipnyap_stream_control_twitch_embed_parent', [
    'label'       => esc_html_x('Twitch Embeds - Parent Domain', '(Customizer) Twitch Embeds Option - Parent Domain - Title', 'yipnyap'),
    'description' => sprintf(
      esc_html_x('In order to be able to use the Twitch Embedded Player (display twitch videos on any part of the site), Twitch requires that your site has a valid SSL certificate (HTTPS site) and that you specify the parent domain/s where the videos will be embedded (i.e.: "mysite.com"). Please enter your site domain/s below, you can enter multiple by separating them with a comma (,).%sYou can check the requirements on this official Twitch post: %shttps://discuss.dev.twitch.tv/t/twitch-embedded-player-updates-in-2020/23956%s', '(Customizer) Twitch Embeds Option - Parent Domain - Description', 'yipnyap'),
      '<br><br>',
      '<a href="https://discuss.dev.twitch.tv/t/twitch-embedded-player-updates-in-2020/23956" target="_blank">',
      '</a>'
    ),
    'type'        => 'text',
    'section'     => 'yipnyap_stream',
    'settings'    => 'yipnyap_stream_setting_twitch_embed_parent',
  ]);
}

add_action('customize_register', 'yipnyap_customizer_stream');
