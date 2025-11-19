import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/reset.css',
                'resources/css/login.css',
                'resources/css/modal.css',
                'resources/css/profile.css',
                'resources/css/create.css',
                'resources/css/directory.css',
                'resources/css/preview.css',
                'resources/css/pagination.css',

                'resources/js/app.js',
                'resources/js/login.js',
                'resources/js/password-reset.js',
                'resources/js/create.js',
                'resources/js/directory.js',
                'resources/js/autosave.js',
                'resources/js/tags-input.js',
                'resources/js/preview.js'
            ],
            refresh: true,
        }),
    ],
});
