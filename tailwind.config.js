import forms from "@tailwindcss/forms";
import defaultTheme from "tailwindcss/defaultTheme";
import plugin from "tailwindcss/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                logo: "#8d949e",
            },
        },
    },

    plugins: [
        forms,
        require("flowbite/plugin"),
        plugin(function ({ addUtilities }) {
            addUtilities({
                ".dark .scrollbar-dark": {
                    "scrollbar-color": "#364153 #1e2939",
                },
                ".dark .scrollbar-dark::-webkit-scrollbar": {
                    "background-color": "#1e2939",
                },
                ".dark .scrollbar-dark::-webkit-scrollbar-thumb": {
                    "background-color": "#364153",
                },
            });
        }),
    ],
};
