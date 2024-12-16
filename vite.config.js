import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin'; // Pastikan ini diimpor
import tailwindcss from 'tailwindcss';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/filament/admin/theme.css'], // File entry utama Laravel
            refresh: true, // Refresh otomatis saat file berubah
        }),
        vue(), // Plugin Vue.js
    ],
    build: {
        manifest: true, // Aktifkan manifest untuk Laravel
        outDir: 'public/build', // Direktori keluaran untuk build
    },
    css: {
        postcss: {
            plugins: [tailwindcss()], // Aktifkan TailwindCSS
        },
    },
});
