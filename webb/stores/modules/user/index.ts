import { defineStore } from "pinia";

import actions from './actions';
import getters from './getters';
import state from './state';

export interface State {
    isLoading: any;
    roles: string[];
    userEmail: string|null;
    token: string|null;
}

export default defineStore('user', {
    state: () => state,
    actions: actions,
    getters: getters,
})
