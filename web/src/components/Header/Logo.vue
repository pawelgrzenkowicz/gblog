<template>
    <div class="logo">
        <RouterLink :to="{ name: '_index' }">
            <picture>
                <source media="(min-width: 1024px)" :srcset="logo">
                <source media="(min-width: 768px)" :srcset="logoMedium">
                <source media="(min-width: 320px)" :srcset="logoSmall">
                <img :src="logo" alt="zmaczowani logo">
            </picture>
        </RouterLink>
    </div>
</template>

<script lang="ts" setup>
    import logo from "@/assets/images/main/original/logo.png";
    import logoSmall from "@/assets/images/main/small/logo.png";
    import logoMedium from "@/assets/images/main/medium/logo.png";
</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';
    @import "@/assets/shared/size-variables";

    @include mobile-S {
        div {
            &.logo {
                display: block;
                justify-content: center;
                height: $mobileLogoSize; // to ustawia pixele przy scrollu

                a {
                    img {
                        height: $mobileLogoSize; // to jest wysokość obrazka
                        object-fit: scale-down;
                        //object-fit: fill;
                        width: 100%;
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
        div {
            &.logo {
                height: $tabletLogoSize; // to ustawia pixele przy scrollu

                a {
                    img {
                        height: $tabletLogoSize; // to jest wysokość obrazka
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
