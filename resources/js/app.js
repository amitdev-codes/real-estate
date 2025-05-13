import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createPinia } from 'pinia'
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import MainLayout from "./layouts/frontend-layout.vue";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";
import vClickOutside from 'v-click-outside';

import Vue3Toastify from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

// vueForm and vueForm config imports
import Vueform from "@vueform/vueform";
import vueformConfig from "../../vueform.config";


const appName = import.meta.env.VITE_APP_NAME || "Dream Estate";

createInertiaApp({
    title: (title) => `${title} | ${appName} `,

    resolve: async (name) => {
        let module = name.split("::");
        let page;

        if (module.length > 1) {
            const moduleName = module[0];
            const pageName = module[1];

            page = await resolvePageComponent(
                `../../Modules/${moduleName}/resources/js/pages/${pageName}.vue`,
                {
                    ...import.meta.glob(
                        "../../Modules/**/resources/js/**/*.vue"
                    ), // For modules
                    ...import.meta.glob("./**/*.vue"), // For main application
                    // ...import.meta.glob(['../../node_modules/@vueform/vueform/themes/tailwind/**/*.vue']),
                    ...import.meta.glob([
                        // '../images/**',
                        "../assets/frontend/new-fonts/**",
                    ]),
                }
            );
        } else {
            page = await resolvePageComponent(
                `./${name}.vue`,
                import.meta.glob("./**/*.vue")
            );
        }

        page.default.layout = page.default.layout || MainLayout;
        return page;
    },

    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        return createApp({ render: () => h(App, props) })
            .component("Head", Head)
            .component("Link", Link)
            .use(pinia)
            .use(plugin)
            .use(ZiggyVue)
            .use(Vue3Toastify)
            .use(VueSweetalert2)
            .use(Vueform, vueformConfig)
            .use(vClickOutside)
            .mount(el);
    },
    progress: {
        color: "#4B5563",
    },
});
