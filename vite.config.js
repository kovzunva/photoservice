import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
 
export default defineConfig({
    plugins: [
        laravel([
            'resources/css/my_style.css',
            'resources/js/most_used.js',
        ]),
    ],
    optimizeDeps: {
      include: ['jquery'],
    },
});