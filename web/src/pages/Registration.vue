<template>
    <main>
        <Container1024 is="article">
            <h1>Zarejestruj</h1>
            <form @submit.prevent>
                <input
                    v-model="email"
                    @input=""
                    class="center"
                    type="text"
                    name="email"
                    placeholder="email"
                >
                <input
                    v-model="nickname"
                    @input=""
                    class="center"
                    type="text"
                    name="nickname"
                    placeholder="nazwa użytkownika"
                >
                <PasswordInput
                    @input="onPasswordInput">
                </PasswordInput>
                <input
                    @click="submitForm"
                    class="center"
                    type="submit"
                    value="Zarejestruj"
                    :disabled="password.valid !== true"
                >
            </form>
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { ref } from "vue";
    import { useStore } from "vuex";
    import { Registration } from "@/models/user/registration";
    import PasswordInput from "@/components/form/registration/PasswordInput.vue";
    import { PasswordRequirements } from "@/composables/UsePasswordInput";
    import Container1024 from "@/components/Container1024.vue";

    const { dispatch } = useStore();

    const email = ref<string>('');
    const nickname = ref<string>('');
    const password = ref<PasswordRequirements>({
        password: '',
        password_repeat: '',
        valid: false,
    })

    function submitForm() {
        dispatch('user/createUser',
            new Registration(
                email.value,
                nickname.value,
                password.value.password,
                password.value.password_repeat)
        );
    }

    const onPasswordInput = (event: PasswordRequirements) => {
        password.value = event;
    }
</script>

<style lang="scss" scoped>
    main {
        h1 {
            margin: 0;
        }

        background-color: $sky-blue;
        form {
            input {
                &.center {
                    display: block;
                    margin: auto;
                }
            }
        }
    }
</style>
