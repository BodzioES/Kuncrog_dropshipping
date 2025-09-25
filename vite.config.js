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
                'resources/js/cookie-navbar.js',
                'resources/css/checkout.css',
                'resources/css/welcome.css',
                'resources/css/cart.css',
                'resources/css/app.css',
                'resources/css/productPage.css',
                'resources/css/product.css',
                'resources/css/admin.css',
                'resources/css/order.css',
                'resources/css/orderShow.css',
                'resources/css/orderEdit.css',
                'resources/css/cartModal.css',
                'resources/css/appCheckout.css',
                'resources/css/user.css',
            ],
            refresh: true,
        }),
    ],
    server: {
        hmr: false,
    },
    resolve: {
        alias: {
            $: "jQuery",
            fontawesome: '@fortawesome/fontawesome-free'
        }
    }
});
