<template>
    <Header />
        <slot />
    <Footer />
</template>

<script lang="ts" setup>
    import Header from "./Header.vue";
    import Footer from "./Footer.vue";
</script>

<style lang="scss">
    @include mobile-S {
        * {
            box-sizing: border-box;
        }

        html, body {
            background-color: $seashell;
            margin: 0;
            padding: 0;
        }

        body > .application {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;

            > div {
                &.content {
                    background-color: $seashell;
                    flex-grow: 1;
                    padding-bottom: 20px;
                    margin-top: 10px;
                }
            }
        }
    }

    @include mobile-M {

    }

    @include mobile-L {

    }

    @include tablet {
        body > .application {
            > div {
                &.content {
                    margin-top: 10px;
                }
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

    }
</style>
