<template>
    <section class="block" :class="{inverse}">

        <ImageRender
            :alt="alt"
            :small-image="smallImage"
            :medium-image="mediumImage"
            :original-image="originalImage"
        />
        <p v-html="description"></p>
    </section>
</template>

<script lang="ts" setup>
    import ImageRender from "@/components/ImageRender.vue";

    const props = defineProps<{
        alt: string,
        description: string,
        inverse: boolean,

        originalImage: string;
        smallImage: string;
        mediumImage: string
    }>();
</script>

<style lang="scss" scoped>



    @include mobile-S {
        section {
            &.block {
                align-items: center;
                background-color: $grain_brown;
                display: flex;
                flex-direction: column;
                justify-content:center;
                padding: 1rem;
                width: 100%;

                &.inverse {
                    flex-direction: column;
                }

                p, picture {
                    padding: 1rem;
                    width: 100%;
                }
                p {
                    color: $seashell;
                    line-height: 125%;
                    text-align: center;
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
            &.block {
                flex-direction: row;

                &.inverse {
                    flex-direction: row-reverse;
                }

                p, picture {
                    margin: 0;
                    max-width: 50%;
                    min-width: 50%;
                    width: 50%;

                    img {
                        object-fit: cover;
                        height: 100%;
                        width: 100%;
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
