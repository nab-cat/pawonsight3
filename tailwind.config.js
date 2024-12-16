import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            screens: {
                '3xl': '1920px', // Add your custom breakpoint here
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                work_sans: ['"Work Sans"', ...defaultTheme.fontFamily.sans], // Add custom font family here
            },
        },
    },
    plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
    ],
};