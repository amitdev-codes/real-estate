import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from "path";

export default defineConfig({
    build: {
        outDir: '../../public/build-property',
        emptyOutDir: true,
        manifest: true,
    },
    plugins: [
        laravel({
            publicDirectory: '../../public',
            buildDirectory: 'build-property',
            input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@pages": path.resolve(
                __dirname, "/resources/js/pages"
            ),
            "@components": path.resolve(
                __dirname, "resources/js/components"
            )
        },
    },
});

//export const paths = [
//    'Modules/Property/resources/assets/sass/app.scss',
//    'Modules/Property/resources/assets/js/app.js',
//];