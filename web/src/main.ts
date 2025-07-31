import { createApp } from 'vue'
import CKEditor from '@ckeditor/ckeditor5-vue'
import i18n from "@/i18n";

import App from './App.vue'
import Router from "./router";
import Store from "./store";

import FontAwesomeIcon from "./assets/shared/font-awesome-icons";

const app = createApp(App);

app.use(Store);
app.use(Router);
app.use(i18n);
app.use(CKEditor);

Store.dispatch('user/reload');

app.component('font-awesome-icon', FontAwesomeIcon);

app.mount(document.body);

