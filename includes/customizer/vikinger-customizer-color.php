<?php
/**
 * Yipnyap Customizer - Colors
 * 
 * @since 1.0.0
 */

function yipnyap_customizer_colors($wp_customize) {
  /**
   * Color Options section
   */
  $wp_customize->add_section('yipnyap_colors_custom_section', [
    'title'       => esc_html_x('Colors - Custom Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the custom preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 100,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_light_section', [
    'title'       => esc_html_x('Colors - Light Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the light preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 101,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_dark_section', [
    'title'       => esc_html_x('Colors - Dark Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the dark preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 102,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_darkblue_section', [
    'title'       => esc_html_x('Colors - Dark Blue Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the dark blue preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 103,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_darkpurple_section', [
    'title'       => esc_html_x('Colors - Dark Purple Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the dark purple preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 104,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_darkcyan_section', [
    'title'       => esc_html_x('Colors - Dark Cyan Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the dark cyan preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 105,
    'panel'       => 'yipnyap_customizer'
  ]);

  $wp_customize->add_section('yipnyap_colors_carbonyellow_section', [
    'title'       => esc_html_x('Colors - Carbon Yellow Preset', '(Customizer) Color Options - Title', 'yipnyap'),
    'description' => esc_html_x('From here, you can change the theme colors of the carbon yellow preset with your desired ones.', '(Customizer) Color Options - Description', 'yipnyap'),
    'priority'    => 106,
    'panel'       => 'yipnyap_customizer'
  ]);

  $color_presets = ['custom', 'light', 'dark', 'darkblue', 'darkpurple', 'darkcyan', 'carbonyellow'];

  foreach ($color_presets as $color_preset) {
    $theme_colors = yipnyap_customizer_theme_colors_get_default($color_preset);

    foreach($theme_colors as $color) {
      $wp_customize->add_setting($color['settings'], [
        'type'              => 'option',
        'default'           => $color['default'],
        'sanitize_callback' => 'sanitize_hex_color',
      ]);

      $wp_customize->add_control(
        new WP_Customize_Color_Control(
          $wp_customize,
          $color['settings'],
          [
            'label'       => $color['label'],
            'description' => $color['description'],
            'section'     => 'yipnyap_colors_'. $color_preset . '_section',
            'settings'    => $color['settings']
          ]
        )
      );
    }
  }
}

add_action('customize_register', 'yipnyap_customizer_colors');
