// import defaultTheme from "tailwindcss/defaultTheme";
// import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    corePlugins: {
        preflight: true,
      },
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/js/**/*.vue",
        // './resources/css/**/*.css',
        // './resources/assets/**/*.scss',
        "./resources/**/*.{vue,js,ts,jsx,tsx}",

        // For laravel modules
        "./Modules/*/resources/views/**/*.blade.php",
        "./Modules/*/resources/js/**/*.vue",
        "./Modules/*/resources/css/**/*.js",

        // For vueForms
        './vueform.config.js',
        './node_modules/@vueform/vueform/themes/tailwind/**/*.vue',
        './node_modules/@vueform/vueform/themes/tailwind/**/*.js',
    ],
    darkMode: "class",
    important: true,
    theme: {
        screens: {
            xs: "540px",
            sm: "640px",
            md: "768px",
            lg: "1024px",
            xl: "1280px",
            "2xl": "1536px",
        },
        container: {
            center: true,
            padding: {
                DEFAULT: "12px",
                sm: "1rem",
                md: "2rem",
                lg: "45px",
                xl: "5rem",
                "2xl": "13rem",
            },
        },

        fontFamily: {
            body: ['"PoppinsRegular", sans-serif'],
        },
        extend: {
            form :(theme) => ({
                primary : 'var(--color-green-600)',
                primaryDarker: 'var(--color-yellow-600)',
            }),
            // fontFamily: {
            //     sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            // },
            // fontFamily: {
            //     'custom': ['"Lora", sans-serif'],
            // },
            screens: {
                lg_992: "992px",
            },
            colors: {
                primary: '#4CAF50', // Match VueForm primary color
                danger: '#FF5252',
                dark: "#3c4858",
                black: "#161c2d",
                "dark-footer": "#161c28",
                green: {
                    600: 'var(--color-green-600)', // Use the CSS variable
                    700: 'var(--color-yellow-600)', // Override the green-700 color globally
                },
                yellow: {
                    600: 'var(--color-yellow-600)', // Use the CSS variable
                    700: 'var(--color-green-600)', // Override the green-700 color globally
                },
                'primary': {
                    '50': '#e3fef9',
                    '100': '#a1ffec',
                    '200': '#40ffd6',
                    '300': '#04c9a8',
                    '400': '#0a6d60',
                    '500': '#00423a',
                    '600': '#00352f',
                    '700': '#012a26',
                    '800': '#02221f',
                    '900': '#041c1a',
                    '950': '#001615',
                    'DEFAULT': '#00423a',
                },
                'secondary': {
                    '50': '#ffffe7',
                    '100': '#feffc1',
                    '200': '#fffc86',
                    '300': '#fff241',
                    '400': '#ffe30d',
                    '500': '#ffd400',
                    '600': '#d19c00',
                    '700': '#a66f02',
                    '800': '#89560a',
                    '900': '#74470f',
                    '950': '#442504',
                    'DEFAULT': '#ffd400',
                },
            },

            boxShadow: {
                sm: "0 2px 4px 0 rgb(60 72 88 / 0.15)",
                DEFAULT: "0 0 3px rgb(60 72 88 / 0.15)",
                md: "0 5px 13px rgb(60 72 88 / 0.20)",
                lg: "0 10px 25px -3px rgb(60 72 88 / 0.15)",
                xl: "0 20px 25px -5px rgb(60 72 88 / 0.1), 0 8px 10px -6px rgb(60 72 88 / 0.1)",
                "2xl": "0 25px 50px -12px rgb(60 72 88 / 0.25)",
                inner: "inset 0 2px 4px 0 rgb(60 72 88 / 0.05)",
                testi: "2px 2px 2px -1px rgb(60 72 88 / 0.15)",
            },

            fontSize: {
                base: ["14px", "18px"],
            },

            spacing: {
                0.75: "0.1875rem",
                3.25: "0.8125rem",
                'px-search-modal' : "300px",
                'px-search-modal-inner' : "500px",
            },

            height: ({ theme }) => ({
                10.5: "2.625rem",
                85: "21.25rem",
            }),
            width: ({ theme }) => ({
                10.5: "2.625rem",
            }),

            maxWidth: ({ theme, breakpoints }) => ({
                1200: "71.25rem",
                992: "60rem",
                768: "45rem",
            }),

            zIndex: {
                1: "1",
                2: "2",
                3: "3",
                999: "999",
            },
        },
    },

    plugins: [
        require("@vueform/vueform/tailwind"),
        {
        forms: {
          strategy: 'class', // only generate classes
        }
      }
    ],
};
