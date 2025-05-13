import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";
import Components from "unplugin-vue-components/vite";

export default defineConfig({
    transpileDependencies: true,
    plugins: [
        Components({
            // relative paths to the directory to search for components.
            dirs: ["resources/js"],
            extensions: ["vue"],
            globs: ["resources/js/*.{vue}"],
            deep: true,

            // resolvers for custom components
            resolvers: [],
        }),
        laravel({
            input: [
                "resources/css/frontend.css",
                "resources/css/backend.css",
                "resources/js/app.js",
            ],
            ssr: "resources/js/ssr.js",
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
    build: {
        rollupOptions: {
            output: {
                assetFileNames: (assetInfo) => {
                    const fileExt = assetInfo.name ? path.extname(assetInfo.name) : '';
    
                    if (fileExt === '.ttf') {
                        return 'assets/new-fonts/[name]-[hash][extname]';
                    }
                    return 'assets/[name]-[hash][extname]';
                }
            }
        }
    },
    
    
    // build: {
    //     rollupOptions: {
    //         output: {
    //             assetFileNames: (assetInfo) => {
    //                 if (assetInfo.originalFileNames?.endsWith('.ttf')) {
    //                     return 'assets/new-fonts/[name]-[hash][extname]';
    //                 }
    //                 return 'assets/[name]-[hash][extname]';
    //             }
    //         }
    //     }
    // },
    server: {
        // host: '192.168.100.118',
        host: '0.0.0.0',
        port: 5173,
      },
    resolve: {
        alias: {
            ziggy: "/vendor/tightenco/ziggy/dist/vue",
            "@backend-assets": path.resolve(
                __dirname,
                "resources/assets/backend"
            ),
            "@frontend-assets": path.resolve(
                __dirname,
                "resources/assets/frontend"
            ),
            "@backend-components": path.resolve(
                __dirname,
                "resources/js/backend/components"
            ),
            "@frontend-components": path.resolve(
                __dirname,
                "resources/js/frontend/components"
            ),
            "@utils": path.resolve(__dirname, "resources/js/utils"),
            "@components": path.resolve(__dirname, "resources/js/Components"),
            "@logo": path.resolve(
                __dirname,
                "resources/assets/logo"
            ),
            "@fonts": path.resolve(__dirname, "resources/assets/frontend/new-fonts"),
            '@Modules': path.resolve(__dirname, 'Modules'),
            "@notifications": path.resolve("Modules/Notifications/resources/js"),
            Agent: path.resolve("Modules/Agent/resources/js"),
            Agency: path.resolve("Modules/Agency/resources/js"),
            Property: path.resolve("Modules/Property/resources/js"),
            Shortlist: path.resolve("Modules/Property/resources/js"),
        },
    },
});
