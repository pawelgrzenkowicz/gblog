<template>
    <main>
        <Container1024 is="article">
            <section class="login">
                <form @submit.prevent="login">
                    <input
                        v-model="email"
                        @input=""
                        class="center"
                        type="text"
                        name="email"
                        placeholder="email"
                    >
                    <input
                        id="password"
                        v-model="password"
                        class="center"
                        name="password"
                        placeholder="password"
                        type="password"
                    />
                    <input
                        class="center btn"
                        type="submit"
                        value="zaloguj"
                        :disabled="email.length <= 0 || password.length <= 0 || isLoading"
                    >
                </form>
            </section>
            <section class="links">
                <div>
                    <RouterLink :to="{ name: 'index' }">
                        reset hasła
                    </RouterLink>
                </div>
                <div>
                    <RouterLink :to="{ name: 'index' }">
                        zarejestruj
                    </RouterLink>
                </div>
            </section>
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { computed, ref } from "vue";
    // import { useStore } from "vuex";
    import { Login } from "@/models/user/login";
    import Container1024 from "@/components/Container1024.vue";
    import storeUser from '@/stores/modules/user/index'


    // const { dispatch, getters } = useStore();
    const userStore = storeUser()

    const email = ref<string>('');
    const password = ref<string>('');

    let isLoading = computed(() => {
        // return getters['user/isLoading'];
        return userStore.getIsLoading
    });

    let isLogged = computed(() => {
        // return getters['user/isLoggedIn'];
        return userStore.isLoggedIn
    });

    function login() {
        // dispatch('user/login', new Login(email.value, password.value))
        userStore.login(new Login(email.value, password.value))
    }
</script>

<style lang="scss" scoped>
    @include mobile-S {
        main {
            article {
                background-color: $brown;
                section {
                    form {
                        padding-top: 20px;
                        input {
                            background-color: $grain_brown;
                            font-family: $roxboro;

                            &.center {
                                display: block;
                                margin: 10px auto;
                            }

                            &.btn {
                                background-color: $grain_brown;
                                border: none;
                                border-radius: 12px;
                                color: $seashell;
                                cursor: pointer;
                                font-family: $roxboro;
                                padding: 10px;
                                margin: 20px auto 0 auto;
                                text-align: center;
                                text-decoration: none;
                            }

                            &::placeholder {
                                color: $brown;
                                font-family: $roxboro;
                            }
                        }

                        label {
                            color: $grain_brown;
                            font-family: $roxboro;
                        }
                    }

                    &.links {
                        margin-top: 5%;
                        padding: 50px 0 20px 0;

                        div {
                            align-items: center;
                            display: flex;
                            height: 50px;
                            justify-content: center;
                            margin: 5px;

                            //font-family: $article_font;

                            a {
                                background-color: $grain_brown;
                                border: none;
                                border-radius: 12px;
                                color: $seashell;
                                font-family: $roxboro;
                                padding: 10px;
                                text-align: center;
                                text-decoration: none;
                            }
                        }


                    }
                }
            }

        }
    }

    @include mobile-M {

    }

    @include mobile-L {

    }

    @include tablet {

    }

    @include laptop {

    }

    @include laptop-L {

    }

</style>
