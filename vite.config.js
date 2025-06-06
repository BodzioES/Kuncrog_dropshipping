import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/delete.js',
                'resources/js/welcome.js',
                'resources/css/checkout.css',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            $: "jQuery",
            fontawesome: '@fortawesome/fontawesome-free'
        }
    }
});
