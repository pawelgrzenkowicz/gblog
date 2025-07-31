import { defineStore } from "pinia";

import actions from './actions';
import getters from './getters';
import state from './state';

export default defineStore('article', {
    state: () => state,
    actions: actions,
    getters: getters,
})
