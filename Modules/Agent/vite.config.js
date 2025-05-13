import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'core-js/fn/promise';
import path from 'path';

export default defineConfig({
    build: {
        outDir: '../../public/build-agent',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-agent',
            input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js'
            ],
            refresh: true,
        }),

    ],
    resolve: {
        alias: {
            "@agent": path.resolve(__dirname, "resources/js/"),
        },
    },
});

//export const paths = [
//    'Modules/Agent/resources/assets/sass/app.scss',
//    'Modules/Agent/resources/assets/js/app.js',
//];
