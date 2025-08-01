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
                'resources/js/modal_delete.js',
                'resources/js/modal_quantity.js',
                'resources/js/checkout.js',
                'resources/js/bootstrap.js',
                'resources/css/checkout.css',
                'resources/css/welcome.css',
                'resources/css/cart.css',
                'resources/css/app.css',
                'resources/css/productPage.css',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/css/order.css',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: false, // jak to nic nie da to do usuniecia
    },
    resolve: {
        alias: {
            $: "jQuery",
            fontawesome: '@fortawesome/fontawesome-free'
        }
    }
});
