import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
 
export default defineConfig({
    plugins: [
        laravel([
            'resources/css/my_style.css',
            'resources/js/most_used.js',
            'resources/js/client.js',
            'resources/js/content_maker.js',
            'resources/js/specified.js',
            'resources/js/lmv.js',
        ]),
    ],
    optimizeDeps: {
      include: ['jquery'],
    },
});