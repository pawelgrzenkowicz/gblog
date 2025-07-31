import { computed, ref, unref } from "vue";
import { UsePasswordAssertion } from "@/composables/UsePasswordAssertion";

export interface PasswordRequirements {
    readonly password: string;
    readonly password_repeat: string;
    readonly valid: boolean;
}

export function UsePasswordInput() {

    const password = ref<string>('');
    const password_repeat = ref<string>('');

    const assertions = UsePasswordAssertion(password, password_repeat);


    const valid = computed<boolean>(() => {
        for (let assertion of assertions) {
            if (!assertion.status) return false;
        }
        return true;
    })

    const requirements = (): PasswordRequirements => ({
        password: unref(password),
        password_repeat: unref(password_repeat),
        valid: unref(valid),
    })

    return {
        assertions,
        password,
        password_repeat,
        valid,
        requirements,
    };
}
