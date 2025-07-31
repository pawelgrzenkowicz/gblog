import { createI18n } from "vue-i18n";
import pl_PL from "@/locales/pl_PL";

const i18n = createI18n({
    locale: 'pl',
    messages: {
        en: {
            message: {
                hello: 'SLUG_VALUE_TOO_SHORT1',
            }
        },

        pl: pl_PL

        // pl: {
        //     pl_PL
        // },
    },
})

export default i18n;
