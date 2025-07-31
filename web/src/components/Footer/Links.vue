<template>
    <section class="links">
        <div class="row-1">
            <RouterLink :to="{ name: '_partnership' }">
                Współpraca
            </RouterLink>
            <RouterLink :to="{ name: '_about_us' }">
                O nas
            </RouterLink>
        </div>
        <div class="row-2">
            <RouterLink :to="{ name: '_sandra' }">
                Sandra
            </RouterLink>
            <RouterLink :to="{ name: '_pawel' }">
                Paweł
            </RouterLink>
        </div>
        <div class="row-3">
            <RouterLink :to="{ name: '_privacy_policy' }">
                Polityka prywatności
            </RouterLink>
        </div>
    </section>
</template>

<script lang="ts" setup>
</script>

<style lang="scss" scoped>

    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        section {
            &.links {
                align-content: center;
                background-color: $grain_brown;
                display: flex;
                flex-direction: column;
                font-family: $roxboro;
                justify-content: center;
                text-align: center;
                div {
                    height: 50px;

                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .row-1 > a, .row-2 > a , .row-3 > a {
                    color: $seashell;
                    padding: 10px;
                    margin: 15px 5px;
                    text-decoration: none;
                    transition: color 0.8s, background-color 0.8s;

                    &:hover {
                        background-color: $seashell;
                        color: $grain_brown;
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
        section {
            background-color: $grain_brown;
            &.links {
                flex-direction: row;
                padding: 3vh 0;

                .row-1 > a, .row-2 > a , .row-3 > a {
                    margin: 15px 50px;
                }
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

    }
</style>
