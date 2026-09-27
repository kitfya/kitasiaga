import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    red: "#dc2626",
                    redHover: "#b91c1c",
                    redDark: "#450a0a",
                    accent: "#059669",
                    accentHover: "#047857",
                    accentLight: "#ecfdf5",
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', "Inter", "sans-serif"],
            },
        },
    },

    plugins: [forms],
};
