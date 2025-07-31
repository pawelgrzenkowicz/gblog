import { State } from "@/stores/modules/user/state";
import { UserRole } from "@/models/user/UserRole";

import userStore from "@/stores/modules/user"

function getState(): State {
    return userStore().$state
}

export default {
    getIsAdmin(): boolean {
        return getState().roles.includes(UserRole.SUPER_ADMIN);
    },

    getIsLoading(): boolean {
        return getState().isLoading;
    },

    isLoggedIn(): boolean {
        return !!getState().token;
    }
};
