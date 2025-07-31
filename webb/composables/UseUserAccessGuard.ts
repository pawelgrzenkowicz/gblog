import userStore from '@/stores/modules/user/index';
import { computed } from "vue";

export function UseUserAccessGuard() {
    return {
        isAdmin: computed<boolean>(() => userStore().getIsAdmin),
        // isAdmin: {value: true},
    };
}
