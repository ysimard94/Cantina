import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import { resolve } from "path";

export default defineConfig({
    base: "/",
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
            publicDir: "public/assets",
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
                compilerOptions: {
                    isCustomElement: (tag) => {
                        return tag.startsWith("ion-"); // (return true)
                    },
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": resolve(__dirname, "resources/js"),
            "@assets": resolve(__dirname, "resources/assets"),
        },
    },
    define: {
        "import.meta.env.VITE_BASE_URL": JSON.stringify(
            "http://localhost:8000/"
        ),
    },
});
