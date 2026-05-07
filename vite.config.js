import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/dashboard.css',
                'resources/js/dashboard.js',
                'resources/css/manajemen-penyakit.css',
                'resources/js/manajemen-penyakit.js',
                'resources/css/create-user.css',
                'resources/js/create-user.js',
                'resources/css/manajemen-user.css',
                'resources/js/manajemen-user.js',
                'resources/css/sebaran.css',
                'resources/js/sebaran.js',
                'resources/css/login.css',
                'resources/js/login.js',
                'resources/css/forgot-password.css',
            ],
            refresh: true,
        }),
    ],
});
