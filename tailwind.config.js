// tailwind.config.js
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    variants: {
        borderWidth: ['responsive', 'last', 'hover', 'focus'],
    },
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
        require('@tailwindcss/ui'),
    ]
}
