<template>
    <main>
        <article class="title">
            <h1>KONTAKT / WSPÓŁPRACA</h1>
        </article>
        <Container1024 is="article">
            <section class="image">
                <ImageRender
                    :alt="'horyzont współpraca'"
                    :small-image="horizonSmall"
                    :medium-image="horizonMedium"
                    :original-image="horizon"
                />
<!--                <img :src="horizon" alt="horyzont">-->
            </section>
            <section class="address">
                <p>Chcesz rozpocząć z nami współpracę?</p>
                <p>Napisz do nas!</p>
                <br>
                <p class="email">{{ contactEmail }}</p>
            </section>
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import horizon from "@/assets/images/main/original/my/para_horyzont.jpg";
    import horizonSmall from "@/assets/images/main/small/my/para_horyzont.jpg";
    import horizonMedium from "@/assets/images/main/medium/my/para_horyzont.jpg";

    import Container1024 from "@/components/Container1024.vue";
    import ImageRender from "@/components/ImageRender.vue";

    import { contactEmail } from "@/../config/parameters";
</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

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
                        color: $brown;
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
        main {
            article {
                section {
                    &.image {
                        height: 50vh;
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
