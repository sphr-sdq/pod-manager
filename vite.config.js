import { defineConfig } from 'vite';
import { fileURLToPath } from 'url'
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Icons from 'unplugin-icons/vite'

export default defineConfig({
    plugins: [
        Icons({ autoInstall: true,}),
        laravel({
            input: 'resources/js/app.js',
            ssr: 'resources/js/ssr.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url))
        },
        extensions: ['.js', '.vue', '.json']
    }
});
