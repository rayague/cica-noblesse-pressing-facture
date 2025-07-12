import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#1E40AF', // Bleu foncé
                secondary: '#F59E42', // Orange doré
                background: '#F3F4F6', // Gris très clair
                text: '#1F2937', // Gris anthracite
                accent: '#10B981', // Vert
                'noble-blue': '#1E40AF', // Bleu noble
                'sky-blue': '#0EA5E9', // Bleu ciel
                'noble-yellow': '#F59E0B', // Jaune noble
                'noble-yellow-light': '#FEF3C7', // Jaune noble clair
            },
        },
    },

    plugins: [forms],
};
