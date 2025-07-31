import { State } from "@/store/modules/user/state";
import { UserRole } from "@/models/user/UserRole";

export default {
    isAdmin(state: State): boolean {
        return state.roles.includes(UserRole.SUPER_ADMIN);
    },

    isLoading(state: State): boolean {
        return state.isLoading;
    },

    isLoggedIn(state: State): boolean {
        return !!state.token;
    }
};
