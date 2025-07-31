import { Ref } from "vue";
import { UseAssertionChain } from "@/composables/UseAssertionChain";

export function UsePasswordAssertion(password: Ref<string>, repeat: Ref<string>) {
    return UseAssertionChain<string>(password, [
        {
            message: 'Musi być cyfra',
            callback: (value) => null !== value.match(/\d/),
        },
        {
            message: 'Musi być minimum 8 znaków',
            callback: (value) => 8 <= value.length,
        },
        {
            message: 'Musi być mała litera',
            callback: (value) => value.toUpperCase() !== value,
        },
        {
            message: 'Musi być wielka litera',
            callback: (value) => value.toLowerCase() !== value,
        },
        {
            message: 'Musi być znak specjalny',
            callback: (value) => value.match(/[!#$%&\'()*\+,-.\/:;<=>?@\[\]^_`{|}~"]/) !== null
        },
        {
            message: 'Hasła muszą być takie same',
            callback: (value) => (repeat.value.length > 0) && (repeat.value === value),
        },
    ]);
}
