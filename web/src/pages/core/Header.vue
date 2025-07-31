<template>
    <header>
        <Menu class="menu" />
        <Logo class="logo" />
        <User class="user" />
    </header>

    <Logo class="logo-screen" />

</template>

<script lang="ts" setup>
import Logo from "@/components/Header/Logo.vue";
import Menu from "@/components/Header/Menu.vue";
import User from "@/components/Header/User.vue";

</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';
    @import "@/assets/shared/size-variables";

    @include mobile-S {
        header {
            display: flex;
            height: $mobileLogoSize;
            justify-content:space-between;
            position: sticky;
            margin-top: 10px;
            top: 0;
            font-family: $roxboro;
            z-index: 1000; // Wojtek czy to jest ok? inaczej elementry przysłaniają menu

            div {
                &.logo {
                    background-color: $seashell;
                    width: calc(100% - 100px);
                }

                &.user {
                    float: right;
                    width: 50px;
                }
            }

            nav {
                &.menu {
                    background-color: $seashell;
                    width: 50px;
                }
            }
        }

        div {
            &.logo-screen {
                display: none;
            }
        }
    }

    @include mobile-M {

    }

    @include mobile-L {

    }

    @include tablet {
        header {
            div {
                &.logo {
                    display: none;
                }

                &.user {
                    float: unset;
                }
            }

            nav {
                &.menu {
                    padding-left: 50px;
                    width: calc(100% - 50px);
                }
            }
        }

        div {
            &.logo-screen {
                background-color: $seashell;
                display: unset;
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

    }

</style>
