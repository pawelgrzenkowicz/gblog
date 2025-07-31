<template>
    <section v-if="articles" class="articles-list">
        <ArticleMiniature
            v-for="(article, index) in articles"

            :formatted-categories="prepareCategories(article)"
            :mainPicture="article.mainPicture"
            :publication-date="showDate(article.publicationDate)"
            :slug="article.slug"
            :title="article.title"
            :truncate-text="truncateParagraphs(article.contents.she)"
            :inverse="index%2!=0"
        >
        </ArticleMiniature>
    </section>
    <section v-if="!articles.length" class="no-articles">
        <articles-not-found />
    </section>
</template>

<script lang="ts" setup>
    import { showDate, truncateParagraphs } from "@/composables/UseTextModifier";
    import ArticlesNotFound from "@/components/Article/ArticlesNotFound.vue";
    import ArticleMiniature from "@/components/Article/ArticleMiniature.vue";
    import { VisibleArticle, type VisibleArticlePOJO } from "@/models/article/visibleArticle";
    import { prepareCategories } from "@/composables/ArticleTool";

    const props = defineProps<{
        articles: VisibleArticlePOJO[]|[]
    }>();
</script>

<style lang="scss" scoped>


    @include mobile-S {

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
