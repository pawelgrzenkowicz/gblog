<template>
    <main>
        <Container1024 is="article">
            <section class="add-article">
                <article>
                    <NuxtLink :to="{ name: 'create-article' }" class="add-article-button">
                        Dodaj artykuł
                    </NuxtLink>
                </article>
            </section>
            <section v-if="articles" class="articles-list">
                <AdminArticleDetails
                    v-for="article in articles"
                    :uuid="article.uuid"
                    :is-removed="article.removed"
                    :is-visible="UseArticleIsVisible(article)"
                    :slug="article.slug"
                    :title="article.title"
                    :views="article.views"
                >
                </AdminArticleDetails>

                <PaginationComponent
                    :items-per-page="itemsPerPage"
                    :total="total"
                    v-model="actualPage"
                />
            </section>
            <section v-if="!articles.length" class="no-articles">
                <articles-not-found />
            </section>

            <ApiErrorsComponent
                v-if="apiErrors"

                :api-errors="apiErrors"
            />

        </Container1024>
    </main>

</template>

<script lang="ts" setup>
    import { Pagination } from "@/models/shared/pagination";
    import { computed, watch } from "vue";

    import AdminArticleDetails from "@/components/Article/AdminArticleDetails.vue";
    import ArticlesNotFound from "@/components/Article/ArticlesNotFound.vue";
    import Container1024 from "@/components/Container1024.vue";
    import PaginationComponent from "@/components/Article/Pagination.vue";
    import { useRoute, useRouter } from "vue-router";
    import ApiErrorsComponent from "@/components/Errors/ApiErrors.vue";
    import { ErrorsObject } from "@/composables/UseErrors";
    import { UseArticleIsVisible } from "@/composables/UseArticleIsVisible";

    import storeArticle from '@/stores/modules/article/index'
    import { usePageQuery } from "@/composables/usePageQuery";

    const articleStore = storeArticle();

    const route = useRoute();
    const router = useRouter();

    const itemsPerPage = 2;

    const { actualPage } = usePageQuery();

    // const actualPage = computed<number>({
    //     get() {
    //         if (null === route.query.page || typeof route.query.page !== 'number') {
    //             return 1;
    //         }
    //         return parseInt(route.query.page);
    //     },
    //     set(value) {
    //         router.push({path: route.fullPath, query: { page: value }})
    //     },
    // });

    let articles = computed(() => {
        return articleStore.getAdminArticlesDetails
        // return getters["article/getAdminArticlesDetails"];
    });

    let total = computed(() => {
        // return getters["article/getTotal"];
        return articleStore.getTotal
    });

    let apiErrors = computed<ErrorsObject|null>(() => {
        // return getters["article/getErrors"];
        return articleStore.getErrors
    });

    // let articles = computed(() => {
    //     return getters["article/getAdminArticlesDetails"];
    // });
    //
    // let total = computed(() => {
    //     return getters["article/getTotal"];
    // });
    //
    // let apiErrors = computed<ErrorsObject|null>(() => {
    //     return getters["article/getErrors"];
    // });


    watch(actualPage, () => {
        // dispatch("article/getAdminArticlesDetails", new Pagination(actualPage.value, itemsPerPage))
        articleStore.fetchAdminArticlesDetails(new Pagination(actualPage.value, itemsPerPage))
    }, { immediate: true });

    // watch(articles, (new1, old1) => {
    //     console.log(new1);
    //     console.log(new1.length);
    // })

    // watch(apiErrors, (new1, old1) => {
    //     console.log(new1);
    //     console.log(new1.length);
    // })

</script>

<style lang="scss" scoped>
    @include mobile-S {
        article {
            section {
                &.add-article {
                    align-items: center;
                    background-color: $brown;
                    display: flex;
                    justify-content: center;
                    height: 25vh;
                    margin: 10vh auto;
                    width: 90%;

                    article {
                        display: flex;
                        justify-content: center;
                        padding: 10px;
                        width: 100%;

                        a {
                            &.add-article-button {
                                background-color: $grain_brown;
                                border-radius: 12px;
                                padding: 10px;
                                color: $seashell;
                                text-decoration: none;
                            }
                        }
                    }
                }
                &.articles-list {
                    article {
                        background-color: $brown;
                        div {
                            &.title {
                                background-color: green;
                            }

                            &.views-number {
                                background-color: yellow;
                            }

                            &.comment-number {
                                background-color: deeppink;
                            }

                            &.actions {
                                background-color: red;
                            }
                        }
                    }
                }

                &.no-articles {
                    margin: 10vh auto;
                    width: 90%;
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
