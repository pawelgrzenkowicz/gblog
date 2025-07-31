<template>
    <main>
        <article class="title">
            <h1>POLITYKA PRYWATNOŚCI</h1>
        </article>
        <Container1024 is="article">
            <section class="address">
                <p>Ta aplikacja nie zbiera informacji użytkowników.</p>
            </section>
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
</script>

<style lang="scss" scoped>
    @include mobile-S {
        main {
            font-family: $roxboro;

            article {
                &.title {
                    background-color: $grain_brown;
                    padding: 5vh 0;
                    margin-bottom: 5vh;
                    text-align: center;

                    h1 {
                        color: $seashell;
                        padding: 0;
                        margin: 0;
                    }
                }
            }
            section {
                &.image {
                    margin-bottom: 5vh;
                    img {
                        object-fit: scale-down;
                        width: 100%;
                    }
                }
                &.address {
                    background-color: $seashell;
                    padding: 5vh 0;
                    text-align: center;

                    p {
                        color: $grain_brown;
                        padding: 0;
                        margin: 0;

                        &.email {
                            font-weight: bold;
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
