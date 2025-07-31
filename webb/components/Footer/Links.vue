<template>
    <section class="links">
        <div class="row-1">
            <NuxtLink :to="{ name: 'partnership' }">
                Współpraca
            </NuxtLink>
            <NuxtLink :to="{ name: 'about-us' }">
                O nas
            </NuxtLink>
        </div>
        <div class="row-2">
            <NuxtLink :to="{ name: 'sandra' }">
                Sandra
            </NuxtLink>
            <NuxtLink :to="{ name: 'pawel' }">
                Paweł
            </NuxtLink>
        </div>
        <div class="row-3">
            <NuxtLink :to="{ name: 'privacy-policy' }">
                Polityka prywatności
            </NuxtLink>
        </div>
    </section>
</template>

<script lang="ts" setup>
</script>

<style lang="scss" scoped>



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
