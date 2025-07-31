import { defineStore } from "pinia";

import actions from './actions';
import getters from './getters';
import state from './state';

export default defineStore('test', {
    state: () => state,
    actions: actions,
    getters: getters,
})
