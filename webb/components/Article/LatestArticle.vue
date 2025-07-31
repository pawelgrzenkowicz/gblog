<template>
    <section v-if="article" class="latest-article">
        <NuxtLink :to="{ name: 'blog-article', params: { slug: article.slug } }">
            <div class="article-info">
                    <div class="info">
                        <h6 v-html="prepareCategories(article)" class="hashtags"></h6>
                        <h2>{{article.title}}</h2>
                        <h6 class="date">&centerdot; {{showDate(article.publicationDate)}} &centerdot;</h6>
                    </div>
            </div>
            <div v-if="article.mainPicture.source" class="image-container">
                <Image
                    :alt="article.mainPicture.alt"
                    :formats="['original', 'medium', 'small']"
                    :src="article.mainPicture.source"
                />
            </div>
        </NuxtLink>
    </section>
    <section v-if="!article" class="latest-article">
        <articles-not-found />
    </section>
</template>

<script lang="ts" setup>
    import ArticlesNotFound from "@/components/Article/ArticlesNotFound.vue";
    import Image from "@/components/Image.vue";
    import { VisibleArticle } from "@/models/article/visibleArticle";
    import { showDate } from "@/composables/UseTextModifier";
    import { prepareCategories } from "@/composables/ArticleTool";

    const props = defineProps<{
        article?: VisibleArticle
    }>();

</script>

<style lang="scss" scoped>
    @include mobile-S {
        section {
            margin-bottom: 100px;
            &.latest-article {
                a {
                    color: inherit;
                    text-decoration: none;

                    div {
                        &.article-info {
                            align-items: center;
                            background-color: $grain_brown;
                            display: flex;
                            justify-content: center;
                            height: 25vh;
                            text-align: center;

                            div {
                                &.info {
                                    height: 100%;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    position: relative;
                                    h2 {
                                        color: $white;
                                        font-size: 2rem;
                                    }

                                    h6 {
                                        &.hashtags {
                                            color: $extra_dark_brown;
                                            position: absolute;
                                            top: 0;
                                            margin: 0.5rem 0 0 0;
                                        }

                                        &.date {
                                            bottom: 0;
                                            color: $extra_dark_brown;
                                            position: absolute;
                                            margin: 0 0 0.5rem 0;
                                        }
                                    }
                                }
                            }
                        }

                        &.image-container {
                            aspect-ratio: 16 / 9;
                            overflow: hidden;
                            width: 100%;
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
        section {
            &.latest-article {
                a {
                    position: relative;

                    div {
                        &.article-info {
                            height: unset;
                            position: absolute;
                            top: 50%;
                            left: 50%;
                            transform: translate(-50%, -50%);
                            width:  75%;

                            div {
                                &.info {
                                    display: unset;

                                    h6 {
                                        &.hashtags {
                                            position: unset;
                                        }

                                        &.date {
                                            position: unset;
                                        }
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
