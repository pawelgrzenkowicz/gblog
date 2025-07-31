<template>
    <article class="miniature">
        <div class="container" :class="{inverse}">
<!--            <RouterLink :to="{ name: '_blog_article', params: {slug: slug} }" class="link-info">-->
            <NuxtLink :to="{ name: 'blog-article', params: {slug: slug} }" class="link-info">
                <div class="article-info">
                        <div class="info">
                            <h6 v-html="formattedCategories"></h6>
                            <h2>{{title}}</h2>
                            <h6 class="date">&centerdot; {{publicationDate}} &centerdot;</h6>
                        </div>
                </div>
            </NuxtLink>
<!--            <RouterLink :to="{ name: '_blog_article', params: {slug: slug} }" class="link-image">-->
            <NuxtLink :to="{ name: 'blog-article', params: {slug: slug} }" class="link-image">
                <div class="image-container">
                        <Image
                            :alt="mainPicture.alt"
                            :formats="['original', 'medium', 'small']"
                            :src="mainPicture.source"
                        />
                </div>
            </NuxtLink>
        </div>
    </article>
</template>

<script lang="ts" setup>
    import Image from "@/components/Image.vue";
    import { Picture } from "@/models/article/picture";

    const props = withDefaults(
        defineProps<{
            formattedCategories: string;
            mainPicture: Picture,
            publicationDate: string,
            slug: string,
            title: string,
            truncateText: string,
            inverse: boolean
        }>(),
        {
            formattedCategories: '',
            mainPicture: () => new Picture('', '', ''),
            publicationDate: '',
            slug: '',
            title: '',
            truncateText: '',
            inverse: false
        }
    );

    // console.log('prop niżej');
    // console.log(props.mainPicture);

    // watch(article, (new1, old1) => {
    //     console.log(new1);
    //     prepareCategories(new1.value);
    //     // console.log(old1);
    // })
</script>

<style lang="scss" scoped>
    @include mobile-S {
        article {
            &.miniature {
                margin-bottom: 100px;
                div {
                    &.container {
                        background-color: $grain_brown;
                        display: flex;
                        flex-flow: column;

                        a {
                            color: inherit;
                            text-decoration: none;

                            &.link-info {
                                order: 2;

                                div {
                                    &.article-info {
                                        align-items: center;
                                        justify-content: center;
                                        text-align: center;

                                        h2 {
                                            color: $seashell;
                                            //font-size: 2rem;
                                        }

                                        h6 {
                                            color: $extra_dark_brown;
                                            margin: 0;

                                            &.date {
                                                margin-bottom: 10px;
                                            }
                                        }
                                    }
                                }
                            }

                            &.link-image {
                                margin-bottom: 30px;
                                order: 1;

                                div {
                                    &.image-container {
                                        aspect-ratio: 16 / 9;
                                        margin: 2.5vw auto 0 auto;
                                        overflow: hidden;
                                        width: 95%;
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
        article {
            &.miniature {
                height: 35vh;
                margin: 40px auto;
                text-align: center;
                h1 {
                    padding: 10px 0;
                }

                p {
                    padding: 10px 0;
                }

                div {
                    &.container {
                        align-items: center;
                        background-color: unset;
                        display: flex;
                        flex-direction: row;
                        flex-flow: nowrap;
                        justify-content: center;
                        height: 100%;

                        &.inverse {
                            flex-direction: row-reverse;

                            a {
                                &.link-info {
                                    //transform: translate(-15%, 0);
                                    transform: translate(-10%, 0);
                                }

                                &.link-image {
                                    //transform: translate(15%, 0);
                                    transform: translate(10%, 0);
                                }
                            }
                        }

                        a {
                            color: inherit;
                            text-decoration: none;

                            &.link-info {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                background-color: $grain_brown;
                                order: unset;
                                height: 70%;
                                width: 50%;
                                //transform: translate(15%, 0);
                                transform: translate(10%, 0);
                                //transform: translate(5%, 0);
                                z-index: 2;

                                div {
                                    &.article-info {
                                        h2 {
                                            color: $seashell;
                                        }

                                        h6 {
                                            margin: unset;

                                            &.date {
                                                margin-bottom: unset;
                                            }
                                        }
                                    }
                                }
                            }

                            &.link-image {
                                height: 100%;
                                margin-bottom: unset;
                                order: unset;
                                //transform: translate(-15%, 0);
                                transform: translate(-10%, 0);
                                //transform: translate(-5%, 0);
                                width: 50%;

                                div {
                                    &.image-container {
                                        margin: unset;
                                        height: 100%;
                                        width: 100%;

                                        img {
                                            object-fit: cover;
                                            height: 100%;
                                            width: 100%;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            &.miniature:last-child {
                margin-bottom: 100px;
            }
        }
    }

    @include laptop {
        article {
            &.miniature {
                height: 40vh;
            }
        }
    }

    @include laptop-L {

    }

</style>
