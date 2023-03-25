const {default: flattenColorPalette} = require('tailwindcss/lib/util/flattenColorPalette');
const defaultColors = require('tailwindcss/colors');

module.exports = {
    preflight: true,
    darkMode: ['class', 'dark'],
    content: [
        './**/*.{html,js,ts,tsx,php}',
        './**/raw/styles.css', // grunt
    ],
    safelist: [
        'bg-neutral-50',
        'dark:bg-neutral-700',
        'dark:bg-neutral-800',
        'text-neutral-900',
        'dark:text-neutral-300',
        'divide-neutral-200',
        'dark:divide-neutral-700',

        // for skeleton loader
        'h-32',
        'h-48',
        'h-40',
        'h-56',

        // for accent
        {
            pattern: /(bg|text|border)-./,
            variants: [
                '!',
                'dark',
                'hover',
                'focus',
                'dark:hover',
                'dark:focus',
            ],
        },
    ],
    theme: {
        extend: {
            colors: {
                code: {
                    highlight: 'rgb(125 211 252 / 0.1)',
                },
                neutralOld: {
                    50: '#fafafa',
                    100: '#f5f5f5',
                    200: '#e5e5e5',
                    300: '#d4d4d4',
                    400: '#a3a3a3',
                    500: '#737373',
                    600: '#525252',
                    700: '#404040',
                    800: '#262626',
                    900: '#171717',
                },
                neutral: defaultColors.zinc,
            },
            aspectRatio: {
                'banner': '3 / 1',
            },
            borderRadius: {
                default: '0.75rem',
            },
            transitionTimingFunction: {
                snapper: 'cubic-bezier(0,1.25,0,1)',
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        function ({
                      matchUtilities,
                      theme,
                  }) {
            matchUtilities(
                {
                    highlight: (value) => ({boxShadow: `inset 0 1px 0 0 ${value}`}),
                },
                {
                    values: flattenColorPalette(theme('backgroundColor')),
                    type: 'color',
                },
            )
        },
    ],
};
