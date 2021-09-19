// Example `tailwind.config.js` file
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
    prefix: '',
    important: true,
    separator: ':',
    theme: {
        extend: {
            fontFamily : {
                'sans' : ['Work Sans', 'sans-serif']
            }
        }
    },
    plugins: [],
}
