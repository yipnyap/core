const {default: flattenColorPalette} = require('tailwindcss/lib/util/flattenColorPalette');
const colors = require('tailwindcss/colors');

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

        // for notification
        'text-green-400',
        'text-red-400',
        'text-yellow-400',
    ],
    theme: {
        extend: {
            colors: {
                code: {
                    highlight: 'rgb(125 211 252 / 0.1)',
                },
                neutral: colors.zinc,
                sidebar: {
                    default: '#ffffff',
                    dark: '#1b1b1c',
                },
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
