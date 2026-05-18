import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import flowbite from 'flowbite/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#00A39D', // BSI Teal
                'primary-dark': '#00827D', // Darker Teal
                secondary: '#ffffff', // White for sidebar
                'background-alt': '#F1F5F9', // Slate-100 for hover
                accent: '#F37021', // BSI Orange
                'accent-dark': '#D96016',
                danger: '#dc2626',
                'danger-dark': '#b91c1c',
            }
        },
    },

    plugins: [forms, flowbite],
};
