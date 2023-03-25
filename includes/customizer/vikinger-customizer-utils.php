<?php
/**
 * Yipnyap Customizer - Utils
 *
 * @since 1.0.0
 */

/**
 * Returns 404 page default image url
 *
 * @return string $image_url      404 page default image url.
 */
function yipnyap_customizer_404_page_image_get_default()
{
    $image_url = YIPNYAP_URL . '/img/error/404.png';

    return $image_url;
}

/**
 * Sanitizes bool value
 *
 * @param bool $value A value that should be a bool.
 * @return bool
 */
function yipnyap_customizer_sanitize_bool($value)
{
    return (bool)$value;
}

/**
 * Sanitizes array value
 *
 * @param array $value A value that should be an array.
 * @return array
 */
function yipnyap_customizer_sanitize_array($value)
{
    return is_array($value) ? $value : [];
}

/**
 * Sanitizes upload maximum size allowed
 *
 * @return int
 */
function yipnyap_customizer_sanitize_upload_maximum_size($value)
{
    $upload_maximum_size = absint($value);
    $server_upload_maximum_size = yipnyap_upload_max_size_get();

    return min($upload_maximum_size, $server_upload_maximum_size);
}

/**
 * Sanitizes text with comma separated values
 *
 * @return int
 */
function yipnyap_customizer_sanitize_text_comma_separated($value)
{
    // remove whitespaces
    $value = preg_replace('/\s+/', '', $value);
    // remove extra commas at start or end
    $value = preg_replace('/^,|,$/', '', $value);

    return $value;
}

/**
 * Sanitizes footer bottom text
 *
 * @param string $text Footer bottom text.
 * @return string $sanitized_text   Footer bottom sanitized text.
 */
function yipnyap_customizer_sanitize_text($text)
{
    $allowed_html = [
        'a' => [
            'href' => [],
            'target' => []
        ],
        'br' => [],
        'span' => [
            'class' => []
        ]
    ];

    return wp_kses($text, $allowed_html);
}

/**
 * Returns RGB color from Hex
 *
 * @param string $hex_color Hexadecimal color.
 * @return string $rgb_color        RGB color.
 */
function yipnyap_customizer_color_hex_to_rgb($hex_color)
{
    $rgb_color = [];

    $i = 1;

    while ($i < strlen($hex_color)) {
        $rgb_color[] = hexdec(substr($hex_color, $i, 2));
        $i += 2;
    }

    $rgb_color = implode(',', $rgb_color);

    return $rgb_color;
}

/**
 * Returns RGBA color from Hex and Opacity
 *
 * @param string $hex_color Hexadecimal color.
 * @param string $opacity Opacity (0-1).
 * @return string $rgba_color       RGBA color.
 */
function yipnyap_customizer_color_hex_to_rgba($hex_color, $opacity)
{
    $rgb_color = [];

    $i = 1;

    while ($i < strlen($hex_color)) {
        $rgb_color[] = hexdec(substr($hex_color, $i, 2));
        $i += 2;
    }

    $rgb_color = implode(',', $rgb_color);

    return 'rgba(' . $rgb_color . ', ' . $opacity . ');';
}

/**
 * Returns preset default color values
 *
 * @param string $preset_name Name of the preset.
 * @return array  $preset_default_colors    Preset default colors.
 */
function yipnyap_customizer_color_preset_default_colors_get($preset_name)
{
    $default = [
        /**
         * Login Register Colors
         */
        '--color-wplogin-header-text' => '#fff',

        /**
         * Header Colors
         */
        '--color-header-background' => '#fff',
        '--color-header-text' => '#fff',
        '--color-header-icon' => '#8b88ff',
        '--color-header-icon-hover' => '#615dfa',
        '--color-header-profile-settings-icon' => '#9b7dff',
        '--color-header-mobilemenu-trigger-icon' => '#fff',
        '--color-header-divider' => '#7a77fd',
//        '--color-header-input-background' => '#dedeea',
        '--color-header-input-placeholder' => '#adafca',
        '--color-header-progressbar-line-gradient-start' => '#41efff',
        '--color-header-progressbar-line-gradient-end' => '#41efff',
        '--color-header-progressbar-underline' => '#4a46c8',

        /**
         * Body Colors
         */
        '--color-body' => '#f8f8fb',

        /**
         * Box Colors
         */
        '--color-box-background' => '#ffffff',
        '--color-box-background-solid' => '#ffffff',
        '--color-box-background-alt' => '#fafafa',
        '--color-box-over-box-background' => '#e5e5e5',
        '--color-box-over-box-light-background' => '#fff',

        /**
         * Box Highlight Colors
         */
        '--color-box-highlight-background' => '#f7f7fb',
        '--color-box-hover-background' => '#f2f2f9',

        /**
         * Box Shadow Colors
         */
        '--color-box-shadow' => '#5e5c9a',
        '--color-overbox-shadow' => '#5e5c9a',
        '--color-overbox-dark-shadow' => '#5e5c9a',
        '--color-overbox-big-shadow' => '#5e5c9a',

        /**
         * Text Colors
         */
        '--color-text' => '#404040',
        '--color-text-alt' => '#a3a3a3',
        '--color-text-alt-2' => '#737373',

        /**
         * Icon Colors
         */
        '--color-icon' => '#adafca',
        '--color-icon-highlighted' => '#3e3f5e',

        /**
         * Border Colors
         */
        '--color-border' => '#e5e5e5',
        '--color-divider' => '#e5e5e5',

        /**
         * Progress Bar Colors
         */
        '--color-progressbar-line-gradient-start' => '#615dfa',
        '--color-progressbar-line-gradient-end' => '#41efff',
        '--color-progressbar-underline' => '#e7e8ee',

        /**
         * Avatar Rank Hexagon Colors
         */
        '--color-avatar-rank-hexagon' => '#45437f',

        /**
         * Primary Colors
         */
        '--color-primary' => '#6366f1',
        '--color-primary-hover' => '#4f46e5',
        '--color-primary-light' => '#a5b4fc',
        '--color-primary-dark' => '#4338ca',
        '--color-primary-shadow' => '#4338ca',

        /**
         * Secondary Colors
         */
        '--color-secondary' => '#615dfa',
        '--color-secondary-hover' => '#5753e4',
        '--color-secondary-dark' => '#45437f',
        '--color-secondary-shadow' => '#615dfa',

        /**
         * Tertiary Colors
         */
        '--color-tertiary' => '#fd4350',
        '--color-tertiary-hover' => '#dd343f',
        '--color-tertiary-shadow' => '#fd4350',


        /**
         * Loading Screen Colors
         */
        '--color-loading-screen-background' => '#3e3f5e',

        /**
         * Loading Bar Colors
         */
        '--color-loading-bar-1' => '#615dfa',
        '--color-loading-bar-2' => '#5d71fb',
        '--color-loading-bar-3' => '#5983fb',
        '--color-loading-bar-4' => '#549afc',
        '--color-loading-bar-5' => '#4eb2fd',
        '--color-loading-bar-6' => '#49c9fe',
        '--color-loading-bar-7' => '#45ddfe',
        '--color-loading-bar-8' => '#41efff',

        /**
         * Overlay Colors
         */
        '--color-overlay' => '#171717'
    ];
    $preset_default_colors = [];
    switch ($preset_name) {
        case 'dark':
            $preset_default_colors = array_merge($default, [
                '--color-wplogin-body' => '#1d2333',
                '--color-header-background' => '#262626',
                '--color-header-progressbar-line-gradient-start' => '#40d04f',
                '--color-header-progressbar-line-gradient-end' => '#d9ff65',
                '--color-header-progressbar-underline' => '#5538b5',
                '--color-body' => '#171717',
                '--color-box-background' => '#262626',
                '--color-box-background-solid' => '#262626',
                '--color-box-background-alt' => '#2d2d2d',
                '--color-box-over-box-background' => '#404040',
                '--color-box-over-box-light-background' => 'var(--color-box-over-box-background)',
                '--color-box-highlight-background' => '#21283b',
                '--color-box-hover-background' => '#293249',
                '--color-box-shadow' => '#000000',
                '--color-overbox-shadow' => '#000000',
                '--color-overbox-dark-shadow' => '#000000',
                '--color-overbox-big-shadow' => '#000000',
                '--color-text' => '#ffffff',
                '--color-text-alt' => '#525252',
                '--color-text-alt-2' => '#737373',
                '--color-icon' => '#616a82',
                '--color-icon-highlighted' => '#ffffff',
                '--color-border' => '#404040',
                '--color-divider' => 'var(--color-border)',

                '--color-primary-dark' => '#a5b4fc',
                '--color-primary-light' => '#4338ca',

                '--color-progressbar-line-gradient-start' => '#40d04f',
                '--color-progressbar-line-gradient-end' => '#d9ff65',
                '--color-progressbar-underline' => '#293249',
                '--color-avatar-rank-hexagon' => '#7750f8',
                '--color-loading-screen-background' => '#1d2333',
                '--color-loading-bar-1' => '#41d04f',
                '--color-loading-bar-2' => '#50d551',
                '--color-loading-bar-3' => '#67dc55',
                '--color-loading-bar-4' => '#7de358',
                '--color-loading-bar-5' => '#99eb5c',
                '--color-loading-bar-6' => '#b1f35f',
                '--color-loading-bar-7' => '#c7f962',
                '--color-loading-bar-8' => '#d6fe65'
            ]);
            break;
        case 'light':
            $preset_default_colors = $default;
        default:
    }

    return $preset_default_colors;
}

/**
 * Returns preset setting name
 *
 * @param string $preset_name Name of the preset.
 * @return string $preset_setting_name      Name of the preset setting.
 */
function yipnyap_customizer_color_preset_setting_name_get($preset_name)
{
    return match ($preset_name) {
        'dark' => 'yipnyap_colors_dark',
        default => 'yipnyap_colors_light',
    };
}

/**
 * Returns shadow style based on shadow type
 *
 * @param string $shadow_type Shadow type.
 * @return string $shadow_style       Shadow style.
 */
function yipnyap_customizer_color_shadow_get($shadow_type, $color)
{
    $shadow_style = '';

    $shadow_color = yipnyap_customizer_color_hex_to_rgb($color);

    switch ($shadow_type) {
        case 'button':
            $shadow_style .= '4px 7px 12px 0 rgba(' . $shadow_color . ', .2)';
            break;
        case 'box':
            $shadow_style .= '0 0 40px 0 rgba(' . $shadow_color . ', .06)';
            break;
        case 'overbox':
            $shadow_style .= '3px 5px 20px 0 rgba(' . $shadow_color . ', .12)';
            break;
        case 'overbox-dark':
            $shadow_style .= '0 0 40px 0 rgba(' . $shadow_color . ', .12)';
            break;
        case 'overbox-big':
            $shadow_style .= '3px 5px 40px 0 rgba(' . $shadow_color . ', .1)';
            break;
        default:

    }

    return $shadow_style;
}

/**
 * Returns default theme colors
 *
 * @param string $preset_name Preset name to get colors of. Optional.
 * @return array $theme_colors      Theme default colors.
 */
function yipnyap_customizer_theme_colors_get_default($preset_name = false)
{
    if ($preset_name) {
        $current_preset = $preset_name;
    } else {
        $current_preset = yipnyap_logged_user_color_theme_get();
    }

    $current_preset_setting_name = yipnyap_customizer_color_preset_setting_name_get($current_preset);
    $current_preset_default_colors = yipnyap_customizer_color_preset_default_colors_get($current_preset);

    $theme_colors = [
        /**
         * Login Register Colors
         */
        '--color-wplogin-header-text' => [
            'type' => 'color',
            'label' => esc_html_x('Login Register Header Text - Color', '(Customizer) Color Options - Login Register Header Text Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the login, register and activation pages header text color.', '(Customizer) Color Options - Login Register Header Text Color - Description', 'yipnyap')
        ],

        /**
         * Header Colors
         */
        '--color-header-background' => [
            'type' => 'color',
            'label' => esc_html_x('Header - Background', '(Customizer) Color Options - Header Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header background color.', '(Customizer) Color Options - Header Background - Description', 'yipnyap')
        ],
        '--color-header-text' => [
            'type' => 'color',
            'label' => esc_html_x('Header Text - Color', '(Customizer) Color Options - Header Text Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the color of the header site title, menu text and submenu arrows.', '(Customizer) Color Options - Header Text Color - Description', 'yipnyap')
        ],
        '--color-header-icon' => [
            'type' => 'color',
            'label' => esc_html_x('Header Icon - Color', '(Customizer) Color Options - Header Icon Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header icons color.', '(Customizer) Color Options - Header Icon Color - Description', 'yipnyap')
        ],
        '--color-header-icon-hover' => [
            'type' => 'color',
            'label' => esc_html_x('Header Icon - Hover Color', '(Customizer) Color Options - Header Icon Hover Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header icons hover color.', '(Customizer) Color Options - Header Icon Hover Color - Description', 'yipnyap')
        ],
        '--color-header-profile-settings-icon' => [
            'type' => 'color',
            'label' => esc_html_x('Header Profile Settings Icon - Color', '(Customizer) Color Options - Header Profile Settings Icon Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header profile settings icon color.', '(Customizer) Color Options - Header Profile Settings Icon Color - Description', 'yipnyap')
        ],
        '--color-header-mobilemenu-trigger-icon' => [
            'type' => 'color',
            'label' => esc_html_x('Header Mobile Menu Trigger Icon - Color', '(Customizer) Color Options - Header Mobile Menu Trigger Icon Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header mobile menu trigger icon color.', '(Customizer) Color Options - Header Mobile Menu Trigger Icon Color - Description', 'yipnyap')
        ],
        '--color-header-divider' => [
            'type' => 'color',
            'label' => esc_html_x('Header Divider - Color', '(Customizer) Color Options - Header Divider Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header dividers color.', '(Customizer) Color Options - Header Divider Color - Description', 'yipnyap')
        ],
        '--color-header-input-placeholder' => [
            'type' => 'color',
            'label' => esc_html_x('Header Input - Placeholder', '(Customizer) Color Options - Header Input Placeholder Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header search input placeholder color.', '(Customizer) Color Options - Header Input Placeholder Color - Description', 'yipnyap')
        ],
        '--color-header-progressbar-line-gradient-start' => [
            'type' => 'color',
            'label' => esc_html_x('Header Progress Bar Line Gradient - Start Color', '(Customizer) Color Options - Header Progress Bar Line Gradient Start Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header rank progress bar line gradient start color.', '(Customizer) Color Options - Header Progress Bar Line Gradient Start Color - Description', 'yipnyap')
        ],
        '--color-header-progressbar-line-gradient-end' => [
            'type' => 'color',
            'label' => esc_html_x('Header Progress Bar Line Gradient - End Color', '(Customizer) Color Options - Header Progress Bar Line Gradient End Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header rank progress bar line gradient end color.', '(Customizer) Color Options - Header Progress Bar Line Gradient End Color - Description', 'yipnyap')
        ],
        '--color-header-progressbar-underline' => [
            'type' => 'color',
            'label' => esc_html_x('Header Progress Bar Underline - Color', '(Customizer) Color Options - Header Progress Bar Underline Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the header rank progress bar underline color.', '(Customizer) Color Options - Header Progress Bar Underline Color - Description', 'yipnyap')
        ],

        /**
         * Body Colors
         */
        '--color-body' => [
            'type' => 'color',
            'label' => esc_html_x('Body', '(Customizer) Color Options - Body - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the body background color.', '(Customizer) Color Options - Body - Description', 'yipnyap')
        ],

        /**
         * Box Colors
         */
        '--color-box-background' => [
            'type' => 'text',
            'label' => esc_html_x('Box Layer 1 - Background', '(Customizer) Color Options - Box Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects layer 1 boxes background color that utilises Unicorn.', '(Customizer) Color Options - Box Background - Description', 'yipnyap')
        ],
        '--color-box-background-solid' => [
            'type' => 'color',
            'label' => esc_html_x('Box Layer 1 - Background Solid', '(Customizer) Color Options - Box Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects layer 1 boxes background color.', '(Customizer) Color Options - Box Background - Description', 'yipnyap')
        ],
        '--color-box-background-alt' => [
            'type' => 'color',
            'label' => esc_html_x('Box Layer 1 - Background Dark', '(Customizer) Color Options - Box Background Dark - Title', 'yipnyap'),
            'description' => esc_html_x('Affects layer 1 boxes dark background color.', '(Customizer) Color Options - Box Background Dark - Description', 'yipnyap')
        ],
        '--color-box-over-box-background' => [
            'type' => 'color',
            'label' => esc_html_x('Box Layer 2 - Background', '(Customizer) Color Options - Box Over Box Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects layer 2 boxes background color.', '(Customizer) Color Options - Box Over Box Background - Description', 'yipnyap')
        ],
        '--color-box-over-box-light-background' => [
            'type' => 'color',
            'label' => esc_html_x('Box Layer 2 - Background Light', '(Customizer) Color Options - Box Over Box Background Light - Title', 'yipnyap'),
            'description' => esc_html_x('Affects layer 2 boxes light background color.', '(Customizer) Color Options - Box Over Box Background Light - Description', 'yipnyap')
        ],

        /**
         * Box Highlight Colors
         */
        '--color-box-highlight-background' => [
            'type' => 'color',
            'label' => esc_html_x('Box Highlight - Background', '(Customizer) Color Options - Box Highlight Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects box highlight background color of items, e.g. unread notifications.', '(Customizer) Color Options - Box Highlight Background - Description', 'yipnyap')
        ],
        '--color-box-hover-background' => [
            'type' => 'color',
            'label' => esc_html_x('Box Hover - Background', '(Customizer) Color Options - Box Hover Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects box hover background color of items, e.g. when hovering over a notification.', '(Customizer) Color Options - Box Hover Background - Description', 'yipnyap')
        ],

        /**
         * Box Shadow Colors
         */
        '--color-box-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'box',
            'label' => esc_html_x('Box - Shadow', '(Customizer) Color Options - Box Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects shadow color of the border of boxes, like post updates and sidebar widget boxes.', '(Customizer) Color Options - Box Shadow - Description', 'yipnyap')
        ],
        '--color-overbox-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'overbox',
            'label' => esc_html_x('Over Box - Shadow', '(Customizer) Color Options - Over Box Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects shadow color of elements that are over boxes, like favorite tags, credit earning tags, slider controls and post options.', '(Customizer) Color Options - Over Box Shadow - Description', 'yipnyap')
        ],
        '--color-overbox-dark-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'overbox-dark',
            'label' => esc_html_x('Over Box Dark - Shadow', '(Customizer) Color Options - Over Box Dark Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects shadow color of elements that are over boxes, like dropdowns, but need a darker shadow.', '(Customizer) Color Options - Over Box Dark Shadow - Description', 'yipnyap')
        ],
        '--color-overbox-big-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'overbox-big',
            'label' => esc_html_x('Over Box Big - Shadow', '(Customizer) Color Options - Over Box Big Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects shadow color of big elements that are over boxes, like post preview information box and dropdowns.', '(Customizer) Color Options - Over Box Big Shadow - Description', 'yipnyap')
        ],

        /**
         * Text Colors
         */
        '--color-text' => [
            'type' => 'color',
            'label' => esc_html_x('Text - Primary', '(Customizer) Color Options - Text Primary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects text primary color.', '(Customizer) Color Options - Text Primary - Description', 'yipnyap')
        ],
        '--color-text-alt' => [
            'type' => 'color',
            'label' => esc_html_x('Text - Secondary', '(Customizer) Color Options - Text Secondary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects text secondary color.', '(Customizer) Color Options - Text Secondary - Description', 'yipnyap')
        ],
        '--color-text-alt-2' => [
            'type' => 'color',
            'label' => esc_html_x('Text - Tertiary', '(Customizer) Color Options - Text Tertiary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects text tertiary color.', '(Customizer) Color Options - Text Tertiary - Description', 'yipnyap')
        ],

        /**
         * Icon Colors
         */
        '--color-icon' => [
            'type' => 'color',
            'label' => esc_html_x('Icon', '(Customizer) Color Options - Icon - Title', 'yipnyap'),
            'description' => esc_html_x('Affects icon color.', '(Customizer) Color Options - Icon - Description', 'yipnyap')
        ],
        '--color-icon-highlighted' => [
            'type' => 'color',
            'label' => esc_html_x('Icon - Highlighted', '(Customizer) Color Options - Icon - Title', 'yipnyap'),
            'description' => esc_html_x('Affects icon color when highlighted or hovering.', '(Customizer) Color Options - Icon Highlighted - Description', 'yipnyap')
        ],

        /**
         * Border Colors
         */
        '--color-border' => [
            'type' => 'color',
            'label' => esc_html_x('Border', '(Customizer) Color Options - Border - Title', 'yipnyap'),
            'description' => esc_html_x('Affects border color.', '(Customizer) Color Options - Border - Description', 'yipnyap')
        ],
        '--color-divider' => [
            'type' => 'color',
            'label' => esc_html_x('Divider and Details', '(Customizer) Color Options - Divider - Title', 'yipnyap'),
            'description' => esc_html_x('Affects divider and details (like the background of requirement checkboxes) color.', '(Customizer) Color Options - Divider - Description', 'yipnyap')
        ],

        /**
         * Progress Bar Colors
         */
        '--color-progressbar-line-gradient-start' => [
            'type' => 'color',
            'label' => esc_html_x('Progress Bar Line Gradient - Start Color', '(Customizer) Color Options - Progress Bar Line Gradient Start Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects global (excluding header) progress bar line gradient start color.', '(Customizer) Color Options - Progress Bar Line Gradient Start Color - Description', 'yipnyap')
        ],
        '--color-progressbar-line-gradient-end' => [
            'type' => 'color',
            'label' => esc_html_x('Progress Bar Line Gradient - End Color', '(Customizer) Color Options - Progress Bar Line Gradient End Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects global (excluding header) progress bar line gradient end color.', '(Customizer) Color Options - Progress Bar Line Gradient End Color - Description', 'yipnyap')
        ],
        '--color-progressbar-underline' => [
            'type' => 'color',
            'label' => esc_html_x('Progress Bar Underline - Color', '(Customizer) Color Options - Progress Bar Underline Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects global (excluding header) progress bar underline color.', '(Customizer) Color Options - Progress Bar Underline Color - Description', 'yipnyap')
        ],

        /**
         * Avatar Rank Hexagon Colors
         */
        '--color-avatar-rank-hexagon' => [
            'type' => 'color',
            'label' => esc_html_x('Avatar Rank Hexagon - Color', '(Customizer) Color Options - Avatar Rank Hexagon Color - Title', 'yipnyap'),
            'description' => esc_html_x('Affects avatar rank hexagon color.', '(Customizer) Color Options - Avatar Rank Hexagon Color - Description', 'yipnyap')
        ],

        /**
         * Primary Colors
         */
        '--color-primary' => [
            'type' => 'color',
            'label' => esc_html_x('Primary', '(Customizer) Color Options - Primary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects primary button background, box underlines, hover text, selection text and background of elements with text or icons inside of them.', '(Customizer) Color Options - Primary - Description', 'yipnyap')
        ],
        '--color-primary-hover' => [
            'type' => 'color',
            'label' => esc_html_x('Primary - Hover', '(Customizer) Color Options - Primary Hover - Title', 'yipnyap'),
            'description' => esc_html_x('Affects primary button hover background color.', '(Customizer) Color Options - Primary Hover - Description', 'yipnyap')
        ],
        '--color-primary-light' => [
            'type' => 'color',
            'label' => esc_html_x('Primary - Light', '(Customizer) Color Options - Primary Light - Title', 'yipnyap'),
            'description' => esc_html_x('Affects text and icon colors over dark backgrounds.', '(Customizer) Color Options - Primary Light - Description', 'yipnyap')
        ],
        '--color-primary-dark' => [
            'type' => 'color',
            'label' => esc_html_x('Primary - Dark', '(Customizer) Color Options - Primary Dark - Title', 'yipnyap'),
            'description' => esc_html_x('Affects highlighted text over light backgrounds.', '(Customizer) Color Options - Primary Dark - Description', 'yipnyap')
        ],
        '--color-primary-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'button',
            'label' => esc_html_x('Primary - Shadow', '(Customizer) Color Options - Primary Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects primary button shadow color.', '(Customizer) Color Options - Primary Shadow - Description', 'yipnyap')
        ],

        /**
         * Secondary Colors
         */
        '--color-secondary' => [
            'type' => 'color',
            'label' => esc_html_x('Secondary', '(Customizer) Color Options - Secondary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects secondary button background, input focus border color, and background of elements with text or icons inside of them.', '(Customizer) Color Options - Secondary - Description', 'yipnyap')
        ],
        '--color-secondary-hover' => [
            'type' => 'color',
            'label' => esc_html_x('Secondary - Hover', '(Customizer) Color Options - Secondary Hover - Title', 'yipnyap'),
            'description' => esc_html_x('Affects secondary button hover background color.', '(Customizer) Color Options - Secondary Hover - Description', 'yipnyap')
        ],
        '--color-secondary-dark' => [
            'type' => 'color',
            'label' => esc_html_x('Secondary - Dark', '(Customizer) Color Options - Secondary Dark - Title', 'yipnyap'),
            'description' => esc_html_x('Affects popup close button background color.', '(Customizer) Color Options - Secondary Dark - Description', 'yipnyap')
        ],
        '--color-secondary-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'button',
            'label' => esc_html_x('Secondary - Shadow', '(Customizer) Color Options - Secondary Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects secondary button shadow color.', '(Customizer) Color Options - Secondary Shadow - Description', 'yipnyap')
        ],

        /**
         * Tertiary Colors
         */
        '--color-tertiary' => [
            'type' => 'color',
            'label' => esc_html_x('Tertiary', '(Customizer) Color Options - Tertiary - Title', 'yipnyap'),
            'description' => esc_html_x('Affects tertiary button background and background of elements with text or icons inside of them. Used for buttons and elements that have negative effects (delete, remove friend, demote group member, etc).', '(Customizer) Color Options - Tertiary - Description', 'yipnyap')
        ],
        '--color-tertiary-hover' => [
            'type' => 'color',
            'label' => esc_html_x('Tertiary - Hover', '(Customizer) Color Options - Tertiary Hover - Title', 'yipnyap'),
            'description' => esc_html_x('Affects tertiary button hover background color.', '(Customizer) Color Options - Tertiary Hover - Description', 'yipnyap')
        ],
        '--color-tertiary-shadow' => [
            'type' => 'shadow',
            'shadow_type' => 'button',
            'label' => esc_html_x('Tertiary - Shadow', '(Customizer) Color Options - Tertiary Shadow - Title', 'yipnyap'),
            'description' => esc_html_x('Affects tertiary button shadow color.', '(Customizer) Color Options - Tertiary Shadow - Description', 'yipnyap')
        ],


        /**
         * Loading Screen Colors
         */
        '--color-loading-screen-background' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Screen - Background', '(Customizer) Color Options - Loading Screen Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the loading screen background color.', '(Customizer) Color Options - Loading Screen Background - Description', 'yipnyap')
        ],

        /**
         * Loading Bar Colors
         */
        '--color-loading-bar-1' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 1', '(Customizer) Color Options - Loading Bar 1 - Title', 'yipnyap'),
            'description' => esc_html_x('The loading bar is made of 8 bars with cascading colors. This setting affects the first loading bar color.', '(Customizer) Color Options - Loading Bar 1 - Description', 'yipnyap')
        ],
        '--color-loading-bar-2' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 2', '(Customizer) Color Options - Loading Bar 2 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the second loading bar color.', '(Customizer) Color Options - Loading Bar 2 - Description', 'yipnyap')
        ],
        '--color-loading-bar-3' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 3', '(Customizer) Color Options - Loading Bar 3 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the third loading bar color.', '(Customizer) Color Options - Loading Bar 3 - Description', 'yipnyap')
        ],
        '--color-loading-bar-4' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 4', '(Customizer) Color Options - Loading Bar 4 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the fourth loading bar color.', '(Customizer) Color Options - Loading Bar 4 - Description', 'yipnyap')
        ],
        '--color-loading-bar-5' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 5', '(Customizer) Color Options - Loading Bar 5 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the fifth loading bar color.', '(Customizer) Color Options - Loading Bar 5 - Description', 'yipnyap')
        ],
        '--color-loading-bar-6' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 6', '(Customizer) Color Options - Loading Bar 6 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the sixth loading bar color.', '(Customizer) Color Options - Loading Bar 6 - Description', 'yipnyap')
        ],
        '--color-loading-bar-7' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 7', '(Customizer) Color Options - Loading Bar 7 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the seventh loading bar color.', '(Customizer) Color Options - Loading Bar 7 - Description', 'yipnyap')
        ],
        '--color-loading-bar-8' => [
            'type' => 'color',
            'label' => esc_html_x('Loading Bar - 8', '(Customizer) Color Options - Loading Bar 8 - Title', 'yipnyap'),
            'description' => esc_html_x('Affects the eighth loading bar color.', '(Customizer) Color Options - Loading Bar 8 - Description', 'yipnyap')
        ],

        /**
         * Overlay Colors
         */
        '--color-overlay' => [
            'type' => 'color_rgba',
            'opacity' => '.96',
            'label' => esc_html_x('Overlay - Background', '(Customizer) Color Options - Overlay Background - Title', 'yipnyap'),
            'description' => esc_html_x('Affects overlay background color (overlay that displays when opening the mobile sidemenu, popups, etc).', '(Customizer) Color Options - Overlay Background - Description', 'yipnyap')
        ],
    ];

    // add settings and default color data
    foreach ($theme_colors as $theme_color_name => $theme_color_data) {
        $theme_colors[$theme_color_name]['settings'] = $current_preset_setting_name . '[' . $theme_color_name . ']';
        $theme_colors[$theme_color_name]['default'] = $current_preset_default_colors[$theme_color_name];
    }

    return $theme_colors;
}

/**
 * Returns user custom theme colors style
 *
 * @return string $custom_colors      User custom theme colors.
 */
function yipnyap_customizer_theme_colors_get()
{
    $default_colors = yipnyap_customizer_theme_colors_get_default();

    $current_preset = yipnyap_logged_user_color_theme_get();
    $current_preset_setting_name = yipnyap_customizer_color_preset_setting_name_get($current_preset);

    $user_custom_colors = get_option($current_preset_setting_name, []);

    // add defaults
    foreach ($default_colors as $key => $value) {
        // if user hasn't entered a color for this, use default color
        if (!array_key_exists($key, $user_custom_colors)) {
            if ($value['type'] === 'shadow') {
                $user_custom_colors[$key] = yipnyap_customizer_color_shadow_get($value['shadow_type'], $value['default']);
            } else if ($value['type'] === 'color_rgba') {
                $user_custom_colors[$key] = yipnyap_customizer_color_hex_to_rgba($value['default'], $value['opacity']);
            } else {
                $user_custom_colors[$key] = $value['default'];
            }
        } else {
            // if this color was customized by the user, convert it to a shadow
            if ($value['type'] === 'shadow') {
                $user_custom_colors[$key] = yipnyap_customizer_color_shadow_get($value['shadow_type'], $user_custom_colors[$key]);
            } else if ($value['type'] === 'color_rgba') {
                $user_custom_colors[$key] = yipnyap_customizer_color_hex_to_rgba($user_custom_colors[$key], $value['opacity']);
            }
        }
    }

    $custom_colors = ':root { ';

    foreach ($user_custom_colors as $key => $value) {
        $custom_colors .= $key . ': ' . $value . ';';
    }

    // add static colors
    $custom_colors .= '--color-notice-overlay-background-primary: rgba(' . yipnyap_customizer_color_hex_to_rgb($user_custom_colors['--color-primary']) . ', .14);';
    $custom_colors .= '--color-notice-overlay-background-secondary: rgba(' . yipnyap_customizer_color_hex_to_rgb($user_custom_colors['--color-secondary']) . ', .14);';
    $custom_colors .= '--color-notice-overlay-background-tertiary: rgba(' . yipnyap_customizer_color_hex_to_rgb($user_custom_colors['--color-tertiary']) . ', .14);';

    $custom_colors .= '--color-avatar-overlay-background: rgba(' . yipnyap_customizer_color_hex_to_rgb($user_custom_colors['--color-secondary']) . ', .9);';

    $custom_colors .= '--footer-navigation-display-mobile: ' . get_theme_mod('yipnyap_footer_setting_navigation_mobile_status', 'none') . ';';

    $custom_colors .= ' }';

    return $custom_colors;
}

/**
 * Returns user custom theme colors
 *
 * @return array $user_custom_colors      User custom theme colors.
 */
function yipnyap_customizer_theme_colors_get_array()
{
    $default_colors = yipnyap_customizer_theme_colors_get_default();

    $current_preset = yipnyap_logged_user_color_theme_get();
    $current_preset_setting_name = yipnyap_customizer_color_preset_setting_name_get($current_preset);

    $user_custom_colors = get_option($current_preset_setting_name, []);

    // add defaults
    foreach ($default_colors as $key => $value) {
        // if user hasn't entered a color for this, use default color
        if (!array_key_exists($key, $user_custom_colors)) {
            if ($value['type'] === 'shadow') {
                $user_custom_colors[$key] = yipnyap_customizer_color_shadow_get($value['shadow_type'], $value['default']);
            } else {
                $user_custom_colors[$key] = $value['default'];
            }
        } else {
            // if this color was customized by the user, convert it to a shadow
            if ($value['type'] === 'shadow') {
                $user_custom_colors[$key] = yipnyap_customizer_color_shadow_get($value['shadow_type'], $user_custom_colors[$key]);
            }
        }
    }

    return $user_custom_colors;
}

/**
 * Returns filtered google fonts
 */
function yipnyap_gfonts_get($args = [])
{
    $defaults = [
        'sort' => 'alpha'
    ];

    $args = array_merge($defaults, $args);

    $gfonts = [];

    $gfonts_api_key = get_theme_mod('yipnyap_font_setting_api_key', '');

    $result = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key=' . $gfonts_api_key, $args);

    if (is_wp_error($result)) {
        return [];
    }

    if ($result['response']['code'] === 200) {
        $gfonts = json_decode($result['body'])->items;
    }

    return $gfonts;
}

/**
 * Returns available fonts to use
 */
function yipnyap_customizer_theme_fonts_available_get()
{
    $fonts = [];

    $gfonts = yipnyap_gfonts_get();

    foreach ($gfonts as $gfont) {
        $fonts[$gfont->family] = $gfont;
    }

    return $fonts;
}

/**
 * Returns fonts as customizer select input options
 */
function yipnyap_customizer_theme_font_options_get()
{
    $font_options = [];

    $fonts = yipnyap_customizer_theme_fonts_available_get();

    foreach ($fonts as $font => $font_data) {
        $font_options[$font] = $font;
    }

    return $font_options;
}

/**
 * Get user custom fonts
 */
function yipnyap_customizer_theme_fonts_custom_get()
{
    $fonts = [
        'primary' => get_theme_mod('yipnyap_font_setting_primary', 'Inter'),
        'secondary' => get_theme_mod('yipnyap_font_setting_secondary', 'Poppins')
    ];

    return $fonts;
}

/**
 * Returns user custom fonts for enqueue
 *
 * @return array $fonts      User custom fonts.
 */
function yipnyap_customizer_theme_fonts_get_for_enqueue()
{
    $fonts = yipnyap_customizer_theme_fonts_custom_get();

    foreach ($fonts as $font => $font_data) {
        $font = implode('+', explode(' ', $font));
    }

    return $fonts;
}

/**
 * Returns user custom fonts style
 *
 * @return string $custom_colors      User custom theme colors.
 */
function yipnyap_customizer_theme_fonts_get_style()
{
    $fonts = get_option('fonts');

    $font_style = '
    :root {
      --font-primary: ' . $fonts['primary'] . ', sans-serif;
      --font-secondary: ' . $fonts['secondary'] . ', sans-serif;
    }
  ';

    return $font_style;
}

?>
