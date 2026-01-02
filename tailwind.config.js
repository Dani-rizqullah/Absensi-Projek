import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography'; // Tambahkan ini

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Aktifkan Dark Mode berdasarkan class agar script tema kita berfungsi
    darkMode: 'class', 

    theme: {
        extend: {
            fontFamily: {
                // Kita tambahkan Plus Jakarta Sans sebagai opsi utama
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            // Kita buat skala warna Zinc yang lebih konsisten untuk tema Obsidian
            colors: {
                zinc: {
                    950: '#09090b',
                }
            }
        },
    },

    plugins: [
        forms,
        typography, // Tambahkan ini
    ],
};