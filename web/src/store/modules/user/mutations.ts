import { State } from "@/store/modules/user/state";

export default {
    logout(state: State): void {
        state.token = null;
        state.userEmail = null;
        state.roles = [];
    },

    setIsLoading(state: State, isLoading: boolean): void {
        state.isLoading = isLoading
    },

    setRoles(state: State, roles: []): void {
        state.roles = roles;
    },

    setToken(state: State, token: string): void {
        state.token = token;
    },

    setUserEmail(state: State, userEmail: string): void {
        state.userEmail = userEmail;
    },


};
