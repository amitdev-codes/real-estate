import en from "@vueform/vueform/locales/en";
import tailwind from "@vueform/vueform/dist/tailwind";
import { defineConfig } from "@vueform/vueform";
import MaskPlugin from "@vueform/plugin-mask";
// import vueform from '@vueform/vueform/dist/vueform';

import "@vueform/vueform/dist/vueform.css";

export default defineConfig({
    // theme: {
    //     ...tailwind,
    //     calendar: {
    //         ...tailwind.calendar,
    //         prev: 'w-8 h-8 flex items-center justify-center absolute left-2 top-2', // Fix width and position
    //         next: 'w-8 h-8 flex items-center justify-center absolute right-2 top-2', // Fix width and position
    //         },
    //     },
    theme: tailwind,
    locales: { en },
    locale: "en",
    classHelpers: true,
    plugins: [MaskPlugin],
    endpoints: {
        uploadTempFile: {
            url: "../temp-file/upload",
            method: "POST",
        },
        removeTempFile: {
            url: "../temp-file/remove-temp",
            method: "DELETE",
        },
        removeFile: {
            url: "../temp-file/remove",
            method: "DELETE",
        },
    },
});
