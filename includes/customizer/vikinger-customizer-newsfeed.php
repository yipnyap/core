<?php
/**
 * Yipnyap Customizer - Newsfeed
 *
 * @since 1.0.0
 */

function yipnyap_customizer_newsfeed($wp_customize) {
  /**
   * Newsfeed section
   */
  $wp_customize->add_section('yipnyap_newsfeed', [
    'title'       => esc_html_x('Newsfeed', '(Customizer) Newsfeed Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can choose newsfeed options.', '(Customizer) Newsfeed Options - Description', 'yipnyap'),
    'priority'    => 285,
    'panel'       => 'yipnyap_customizer'
  ]);

  /**
   * Newsfeed YouTube Playback Limit
   */
  $wp_customize->add_setting('yipnyap_newsfeed_setting_yt_playback_limit', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'no'
  ]);

  $wp_customize->add_control('yipnyap_newsfeed_control_yt_playback_limit', [
    'label'       => esc_html_x('Limit YouTube Playback', '(Customizer) Newsfeed Option - Limit Youtube Playback - Title', 'yipnyap'),
    'description' => sprintf(
      esc_html_x('You can choose to limit YouTube embedded video playbacks on the newsfeed of the site. If you select "Yes", only one YouTube video will be played at a time, this means that, if a user is playing a video and chooses to play another one, then the previous video will be paused. The %sYouTube Player API%s is used to achieve this behaviour.', '(Customizer) Newsfeed Option - Limit YouTube Playback - Description', 'yipnyap'),
      '<a href="https://developers.google.com/youtube/iframe_api_reference" target="_blank">',
      '</a>'
    ),
    'type'        => 'radio',
    'choices'     => [
      'yes' => esc_html__('Yes', 'yipnyap'),
      'no'  => esc_html__('No', 'yipnyap'),
    ],
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_newsfeed_setting_yt_playback_limit'
  ]);

  /**
   * Activity Show More Status
   */
  $wp_customize->add_setting('yipnyap_activity_setting_show_more_status', [
    'sanitize_callback' => 'sanitize_text_field',
    'default'           => 'enabled'
  ]);

  $wp_customize->add_control('yipnyap_activity_control_show_more_status', [
    'label'       => esc_html_x('Activity - Show More Status', '(Customizer) Activity Option - Show More Status - Title', 'yipnyap'),
    'description' => esc_html_x('By enabling this option, a "Show More" button will appear on activities that have a large height.', '(Customizer) Activity Option - Show More Status - Description', 'yipnyap'),
    'type'        => 'radio',
    'choices'     => [
      'enabled'   => esc_html__('Enabled', 'yipnyap'),
      'disabled'  => esc_html__('Disabled', 'yipnyap')
    ],
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_show_more_status'
  ]);

  /**
   * Activity Show More Height
   */
  $wp_customize->add_setting('yipnyap_activity_setting_show_more_height', [
    'sanitize_callback' => 'absint',
    'default'           => 1000
  ]);

  $wp_customize->add_control('yipnyap_activity_control_show_more_height', [
    'label'       => esc_html_x('Activity - Show More Height', '(Customizer) Activity Option - Show More Height - Title', 'yipnyap'),
    'description' => esc_html_x('You can control the maximum height that the feed activities can have. If an activity has a height that is greater than this value, then the remaining content will be hidden and a "Show More" button will be created to allow users to display the remaining activity content.', '(Customizer) Activity Option - Show More Height - Description', 'yipnyap'),
    'type'        => 'number',
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_show_more_height'
  ]);

  /**
   * Activity Character Limit
   */
  $wp_customize->add_setting('yipnyap_activity_setting_character_limit', [
    'sanitize_callback' => 'absint',
    'default'           => 2000
  ]);

  $wp_customize->add_control('yipnyap_activity_control_character_limit', [
    'label'       => esc_html_x('Activity - Character Limit', '(Customizer) Activity Option - Character Limit - Title', 'yipnyap'),
    'description' => esc_html_x('You can control the maximum number of characters that users can put into an activity.', '(Customizer) Activity Option - Character Limit - Description', 'yipnyap'),
    'type'        => 'number',
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_character_limit'
  ]);

  /**
   * Activity Comment Character Limit
   */
  $wp_customize->add_setting('yipnyap_activity_setting_comment_character_limit', [
    'sanitize_callback' => 'absint',
    'default'           => 500
  ]);

  $wp_customize->add_control('yipnyap_activity_control_comment_character_limit', [
    'label'       => esc_html_x('Activity - Comment Character Limit', '(Customizer) Activity Option - Comment Character Limit - Title', 'yipnyap'),
    'description' => esc_html_x('You can control the maximum number of characters that users can put into an activity comment (this limit also applies for blog post comments).', '(Customizer) Activity Option - Comment Character Limit - Description', 'yipnyap'),
    'type'        => 'number',
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_comment_character_limit'
  ]);

  /**
   * Activity Edit Time Limit
   */
  $wp_customize->add_setting('yipnyap_activity_setting_edit_time_limit', [
    'sanitize_callback' => 'absint',
    'default'           => 5
  ]);

  $wp_customize->add_control('yipnyap_activity_control_edit_time_limit', [
    'label'       => esc_html_x('Activity - Edit Time Limit (Minutes)', '(Customizer) Activity Option - Edit Time Limit - Title', 'yipnyap'),
    'description' => esc_html_x('You can set the time (in minutes) in which a user is able to edit an activity since he created it (if set to 0, users won\'t be able to edit activities after they create them). This setting doesn\'t apply for site admins, group admins and mods.', '(Customizer) Activity Option - Edit Time Limit - Description', 'yipnyap'),
    'type'        => 'number',
    'input_attrs' => [
      'min'   => 0,
      'step'  => 1
    ],
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_edit_time_limit'
  ]);

  /**
   * Activity Line Break Limit
   */
  $wp_customize->add_setting('yipnyap_activity_setting_line_break_limit', [
    'sanitize_callback' => 'absint',
    'default'           => 2
  ]);

  $wp_customize->add_control('yipnyap_activity_control_line_break_limit', [
    'label'       => esc_html_x('Activity - Line Break Limit', '(Customizer) Activity Option - Line Break Limit - Title', 'yipnyap'),
    'description' => esc_html_x('You can control the maximum amount of consecutive line breaks that users can input in activities text.', '(Customizer) Activity Option - Line Break Limit - Description', 'yipnyap'),
    'type'        => 'number',
    'input_attrs' => [
      'min'   => 0,
      'step'  => 1
    ],
    'section'     => 'yipnyap_newsfeed',
    'settings'    => 'yipnyap_activity_setting_line_break_limit'
  ]);
}

add_action('customize_register', 'yipnyap_customizer_newsfeed');
