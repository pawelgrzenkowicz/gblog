<template>
    <nav>
        <div class="menu">
            <div class="navigation">
                <a class="hamburger-menu active" @click="toggleHamburger">
                    <FontAwesomeIcon :icon="['fas', 'bars']" />
                </a>
            </div>
            <div id="page-mask"></div>
            <div id="side-menu" @click="toggleHamburger">
                <div class="top-container">
                    <div class="logo">
                        <picture>
                            <source media="(min-width: 320px)" :srcset="logoSmall">
                            <img :src="logoSmall" alt="zmaczowani logo">
                        </picture>
                    </div>
                    <div class="xmark">
                        <a class="close-icon">
                            <FontAwesomeIcon :icon="['fas', 'xmark']" />
                        </a>
                    </div>
                </div>

                <div class="links">
                    <NuxtLink :to="{ name: 'index' }">
                        Strona główna
                    </NuxtLink>
                    <NuxtLink :to="{ name: 'blog' }" >
                        Blog
                    </NuxtLink>
                    <NuxtLink :to="{ name: 'about-us' }">
                        O nas
                    </NuxtLink>
                    <NuxtLink :to="{ name: 'partnership' }">
                        Współpraca
                    </NuxtLink>
                    <NuxtLink :to="{ name: 'admin' }" v-if="isAdmin">
                        Admin
                    </NuxtLink>
                </div>
            </div>
        </div>
    </nav>
</template>

<script lang="ts" setup>
    import logoSmall from "@/assets/images/main/small/logo.png";

    import { UseUserAccessGuard } from "@/composables/UseUserAccessGuard";
    import { onMounted } from "vue";

    function toggleHamburger() {
        if (window.innerWidth >= 768) {
            return;
        }

        let element = document.getElementById("side-menu") as HTMLDivElement;
        let mask = document.getElementById("page-mask") as HTMLDivElement;
        if (element.style.left === "0px") {
            element.style.left = "-400px";
            mask.style.display = "none";
        } else {
            element.style.left = "0";
            mask.style.display = "block";
        }
    }

    const { isAdmin } = UseUserAccessGuard();
</script>

<style lang="scss" scoped>
    @include mobile-S {
        nav {
            background-color: #333;
            height: 100%;
            position: sticky;
            top: 0;
            width: 100%;

            div.menu {
                align-items: center;
                display: flex;
                height: 100%;
                width: 100%;

                div {
                    &.navigation {
                        align-items: center;
                        display: inline-block;
                        height: 100%;
                        width: 100%;

                        a {
                            &.hamburger-menu {
                                align-items: center;
                                color: $grain_brown;
                                cursor: pointer;
                                display: flex;
                                height: 100%;
                                font-size: 17px;
                                padding: 14px 16px;
                                text-decoration: none;
                                width: 100%;
                                position: relative;
                            }

                            &.active {
                                cursor: pointer;
                            }
                        }
                    }

                    &#page-mask {
                        display: none;
                        position: fixed;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        top: 0;
                        background-color: rgba(0,0,0,0.6);
                    }

                    &#side-menu {
                        background-color: $seashell;
                        left: -400px;
                        max-height: calc(90vh - 70px);
                        overflow-y: auto;
                        position: fixed;
                        right: auto;
                        top: 0;
                        transition: left 0.4s ease 0s;
                        width: 250px;

                        div {
                            &.top-container {
                                display: flex;
                                height: 100px;
                                padding: 10px;
                                position: relative;

                                div {
                                    &.logo {
                                        display: inline-block;
                                        height: 100%;
                                        width: 200px;

                                        img {
                                            object-fit: scale-down;
                                        }
                                    }

                                    &.xmark {
                                        color: $grain_brown;
                                        display: inline-block;
                                        font-size: 2rem;
                                        height: 100%;
                                        margin: 0 auto;

                                        a {
                                            &.close-icon {
                                                align-items: center;
                                                cursor: pointer;
                                                display: flex;
                                                height: 100%;
                                                padding: 0;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        div {
                            &.links {
                                margin: 0 20%;
                                text-align: center;
                                width: 50%;

                                a {
                                    border-bottom: 1px solid;
                                    border-color: $brown;
                                    color: $brown;
                                    cursor: pointer;
                                    display: block;
                                    padding: 14px 16px;
                                    text-decoration: none;

                                    &:last-child {
                                        border-bottom: unset;
                                        border-color: unset;
                                    }
                                }
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
        nav {
            div.menu {
                background: unset;

                div {
                    &.navigation {
                        display: none;
                    }

                    &#page-mask {
                        display: none;
                    }

                    &#side-menu {
                        display: block;
                        left: unset;
                        max-height: unset;
                        overflow-y: unset;
                        position: unset;
                        right: unset;
                        top: unset;
                        transition: unset;
                        width: 100%;

                        div {
                            &.top-container {
                                display: none;
                            }
                        }

                        div {
                            &.links {
                                margin: unset;
                                width: unset;

                                a {
                                    border-bottom: unset;
                                    border-color: unset;
                                    cursor: pointer;
                                    display: inline-block;
                                    margin: 0 10px;
                                    transition: color 0.8s, background-color 0.8s;

                                    &:hover {
                                        background-color: $grain_brown;
                                        color: $seashell;
                                    }

                                    &:last-child {
                                        border-bottom: unset;
                                        border-color: unset;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

}


</style>
