const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./src/**/*.{html,js}",
    ],

    theme: {
        extend: {
            screens: {
                sm: "480px",
                md: "768px",
                lg: "1024px",
                xl: "1280px"
            },
            fontSize: { //.INFO_template: 'name' : ['fontSize', 'lineHeight'],
                'heading1': ['96px', '115px'],
                'heading2': ['60px', '72px'],
                'heading3': ['48px', '58px'],
                'heading4': ['34px', '41px'],
                'heading5': ['24px', '29px'],
                'heading6': ['20px', '24px'], //? 24px lineHeight? Navragen bij Adi...
                'paragraphL': ['24px', '29px'],
                'paragraphM': ['20px', '24px'], //? 24px lineHeight? Navragen bij Adi...
                'paragraphS': ['16px', '19px'], //? 19px lineHeight? Navragen bij Adi...
                'button': ['20px', '24px'], //? 24px lineHeight? Navragen bij Adi...
                'caption': ['14px', '17px'],
                'text': ['24px', '32px'],
            },
            dropShadow: {
                'box': '2px 12px 6px rgba(8, 144, 166, 1)',
            },
            animation: {
                'bounce-slow': 'bounce 2s infinite',
            },
            colors: {
                'blue': '#00ACC7',
                'dark': '#2F2E41',
                'basic': '#EEFFFD',
                lightBlue: '#00ACC7',
                stone: 'rgb(148 163 184)',
                danger: '#ef4444',
                success: '#22c55e',
                darker: '#f1f5f9',
                successDarker: '#16a34a',
                successDarker2: '#15803d'
            },
            fontFamily: {
                'roboto': ['Roboto', 'sans-serif'],
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
