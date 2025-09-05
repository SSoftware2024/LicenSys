import { defineConfig } from "vite";
import { fileURLToPath, URL } from "url"; //novo
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue"; //novo
export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
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
            vue: "vue/dist/vue.esm-bundler.js",
            "@" : fileURLToPath(new URL("./resources/js", import.meta.url)),
            "@layout" : fileURLToPath(new URL("./resources/js/layouts", import.meta.url))
        }
    },
});
