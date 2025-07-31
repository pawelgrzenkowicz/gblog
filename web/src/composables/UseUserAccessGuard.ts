import Store from '@/store';
import { computed } from "vue";

export function UseUserAccessGuard() {
    return {
        isAdmin: computed<boolean>(() => Store.getters['user/isAdmin']),
    };
}
