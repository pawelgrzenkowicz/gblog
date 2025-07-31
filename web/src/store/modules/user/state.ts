import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export interface State {
    isLoading: any;
    roles: string[];
    userEmail: string|null;
    token: string|null;
}

export default {
    namespaced: true,
    state: <State>{
        isLoading: false,
        roles: [],
        // roles: ['ROLE_FREE_USER'],
        // roles: ['ROLE_SUPER_ADMIN'],
        userEmail: null,
        // token: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MTgyMDYwNTMsImV4cCI6MTcxODI5MjQ1Mywicm9sZXMiOlsiUk9MRV9TVVBFUl9BRE1JTiJdLCJ1c2VybmFtZSI6InptYWN6b3dhbmlAem1hY3pvd2FuaS5kZXYifQ.qwVHI5xRuCIdNUvQzpjMmhXBeXwxdIUmwPTASAuCA-405oYbME0ukopLgNx7nYGa6-0AbEAK9KI0DCkFMByTjJmp10wSn69hjUhrB33b9Wi3XE37XWpScYl3UcGBoqi8xAHoQmvQYuU629Ip7YdKnsCF_KG1oLvlG7JNFis7-hgEN6OkYAEt-tyginI6MBehqLsrWhmYehDuql0uf5oVOLE49Br3J5ARhADSU0zn8dQiYLafBL4g8JUkD3V778oO-rDhqW9gv9e8MBQ49IwIlqfUfJ7sWpIUSwnDHTxd13lOY3hNxPmIfr__Y-nvh77C7CRhaphvxjWt6_hS-foy5w',
        token: null,

    },

    actions,
    getters,
    mutations,
}
