import { computed, reactive, Ref, unref } from "vue";

interface Validator<T> {
    callback: (value: T) => boolean;
    message: string;
}

interface ReactiveAssertion {
    message: string;
    status: Ref<boolean>;
}

export function UseAssertionChain<T>(value: Ref<T>, validators: Validator<T>[]): ReactiveAssertion[] {
    const assertions: any[] = [];

    for (let { callback, message } of validators) {
        const status = computed<boolean>(() => callback(unref(value)));

        assertions.push(
            reactive({ message, status })
        )
    }

    return assertions;
}
