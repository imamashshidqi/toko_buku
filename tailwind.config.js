// tailwind.config.js

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            // Kustomisasi tema Anda bisa tetap di sini
        },
    },

    // ===== DI SINI TEMPATNYA MENAMBAHKAN PLUGIN =====
    plugins: [
        require("@tailwindcss/forms"),
        require("flowbite/plugin"), // Contoh dari pembahasan sebelumnya
        // require('@tailwindcss/typography'), // Contoh plugin lain
        // ...daftarkan plugin lain di sini
    ],
};
