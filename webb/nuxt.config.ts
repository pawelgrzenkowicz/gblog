import { defineNuxtConfig } from "nuxt/config";

export default defineNuxtConfig({
    plugins: [
        '@/plugins/font-awesome-icons.ts',
    ],
    modules: [
        '@pinia/nuxt',
        '@vesp/nuxt-fontawesome',
        '@nuxtjs/i18n',
    ],
    compatibilityDate: '2024-11-01',
    devtools: {
        enabled: true
    },
    vite: {
        build: {
            outDir: "../public",
            emptyOutDir: true,
        },
        css: {
            preprocessorOptions: {
                scss: {
                    api: 'modern',
                    additionalData: `
                        @use '@/assets/shared/breakpoints.scss' as *;
                        @use '@/assets/shared/colors.scss' as *;
                        @use '@/assets/shared/fonts.scss' as *;
                        @use '@/assets/shared/size-variables.scss' as *;
                    `
                }
            }
        }
    },
    runtimeConfig: {
        public: {
            API_HOST: process.env.API_HOST,
            IMAGE_HOST: process.env.IMAGE_HOST,

            CONTACT_EMAIL: 'zmaczowani.kontakt@gmail.com',

            ARTICLE_CONTENT_PICTURE_PATH: 'article/content',
            MAIN_PICTURE_PATH: 'article/main',

            FACEBOOK_LINK: 'https://www.facebook.com/profile.php?id=61560439277027',
            INSTAGRAM_LINK: 'https://www.instagram.com/zmaczowanii',
            YOUTUBE_LINK: 'https://www.youtube.com/@zmaczowani',
            TIKTOK_LINK: 'https://www.tiktok.com/@zzmaczowani',
        }
    },
    build: {
        transpile: [
            '@fortawesome/vue-fontawesome',
        ]
    },
    i18n: {
        vueI18n: './i18n.config.ts'
    }
})
