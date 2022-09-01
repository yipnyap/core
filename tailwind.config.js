const {default: flattenColorPalette} = require('tailwindcss/lib/util/flattenColorPalette')
module.exports = {
    content: [
        './**/*.{html,js,php}',
    ],
    theme: {
        extend: {
            colors: {
                code: {
                    highlight: 'rgb(125 211 252 / 0.1)',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        function ({matchUtilities, theme}) {
            matchUtilities(
                {
                    highlight: (value) => ({boxShadow: `inset 0 1px 0 0 ${value}`}),
                },
                {values: flattenColorPalette(theme('backgroundColor')), type: 'color'}
            )
        },
    ],
};
