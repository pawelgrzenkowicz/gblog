import { defineConfig } from "vite"
import vue from "@vitejs/plugin-vue"
import { resolve } from "path";


function ABSOLUTE(name, dirname = __dirname) {
    return resolve(dirname, name);
}


// https://vitejs.dev/config/
export default defineConfig({
    server: {
        host: true,
    },

    build: {
        outDir: "../public",
        emptyOutDir: true,
    },

    css: {

        preprocessorOptions: {
            scss: {
                additionalData: `
                    // @import "";
                    // @import "";
                    @import "@/assets/shared/colors.scss";
                    @import "@/assets/shared/fonts.scss";
                `
            }
        }
    },

    plugins: [vue()],
    resolve: {
        alias: {
            // "@": ABSOLUTE("./src"),
            "@": ABSOLUTE("./src"),
        },
        // extensions: [".js", ".vue"],
    },
    root: ABSOLUTE("src"),
    envDir: ABSOLUTE('.'),
})
