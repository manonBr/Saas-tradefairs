import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/fonts/icomoon/style.css', 'resources/css/app.css', 'resources/css/dashboard.css', 'resources/js/app.js', 'resources/js/update-price-in-order.js'],
            refresh: true,
        }),
    ],
});
