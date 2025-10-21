import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react-swc';

export default defineConfig({
    plugins: [
        react(),
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

                // React SPA entry
                'resources/react/main.tsx',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/react/src',
        },
    },
    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    'alpine': ['alpinejs'],
                    'aos': ['aos'],
                    'chart': ['chart.js'],
                    'vendor': ['axios'],
                },
                // Optimize chunk names for better caching
                chunkFileNames: 'assets/[name]-[hash].js',
                entryFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash].[ext]',
            },
        },
        chunkSizeWarningLimit: 1000,
        // Enable source maps for production debugging
        sourcemap: false,
        // Optimize for production
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
    },
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});

