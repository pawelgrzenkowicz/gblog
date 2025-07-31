import { defineI18nConfig } from "@/.nuxt/imports";
import pl_PL from "@/locales/pl_PL";

export default defineI18nConfig(() => ({
    legacy: false,
    locale: 'pl',
    messages: {
        pl: pl_PL,
        en: {
            welcome: 'Welcome11'
        },
    }
}))
