import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // CSS Files
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/mosaic.css',
                'resources/css/stellar.css',
                
                // JS Files
                'resources/js/app.js',
                'resources/js/admin.js',
                'resources/js/mosaic.js',
                'resources/js/stellar.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'alpine': ['alpinejs'],
                    'aos': ['aos'],
                    'chart': ['chart.js'],
                },
            },
        },
        chunkSizeWarningLimit: 1000,
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});

