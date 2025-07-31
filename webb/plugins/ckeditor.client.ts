import { defineNuxtPlugin } from 'nuxt/app'

import { Ckeditor } from '@ckeditor/ckeditor5-vue';

export default defineNuxtPlugin((nuxtApp) => {
    nuxtApp.vueApp.component('ckeditor', Ckeditor);
});
