import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/css/filament/admin/theme.css'
            ],
            refresh: true,
        }),
        vue(),
    ],
    build: {
        manifest: true,
        outDir: 'public/build',
    },
    css: {
        postcss: {
            plugins: [tailwindcss()],
        },
    },
});