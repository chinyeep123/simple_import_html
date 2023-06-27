import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import AutoImport from "unplugin-auto-import/vite";
import Components from "unplugin-vue-components/vite";
import { ElementPlusResolver } from "unplugin-vue-components/resolvers";
import { createSvgIconsPlugin } from "vite-plugin-svg-icons";
import UnoCSS from "unocss/vite";
import { presetAttributify, presetIcons, presetUno } from "unocss";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
        vue(),
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
        createSvgIconsPlugin({
            iconDirs: [
                path.resolve(process.cwd(), "resources/js/icons/common"),
                path.resolve(process.cwd(), "resources/js/icons/nav-bar"),
            ],
            symbolId: "icon-[dir]-[name]",
        }),
        UnoCSS({
            presets: [
                presetAttributify({
                    /* preset options */
                }),
                presetIcons(),
                presetUno(),
                // ...custom presets
            ],
        }),
    ],
    resolve: {
        alias: {
            "~bootstrap": path.resolve(__dirname, "node_modules/bootstrap"),
            "@": "/resources/js",
        },
    },
    build: {
        chunkSizeWarningLimit: 1600,
        sourcemap: true,
        outDir: "public/build", //指定输出路径
        assetsDir: "static/img/", // 指定生成静态资源的存放路径
        rollupOptions: {
            output: {
                manualChunks(id) {
                    if (id.includes("node_modules")) {
                        const arr = id
                            .toString()
                            .split("node_modules/")[1]
                            .split("/");
                        switch (arr[0]) {
                            case "@naturefw": // 自然框架
                            case "@popperjs":
                            case "@vue":
                            case "element-plus": // UI 库
                            case "@element-plus": // 图标
                                return "_" + arr[0];
                                break;
                            default:
                                return "__vendor";
                                break;
                        }
                    }
                },
                chunkFileNames: "static/js1/[name]-[hash].js",
                entryFileNames: "static/js2/[name]-[hash].js",
                assetFileNames: "static/[ext]/[name]-[hash].[ext]",
            },
            brotliSize: false, // 不统计
            target: "esnext",
            minify: "esbuild", // 混淆器，terser构建后文件体积更小
        },
    },
});
