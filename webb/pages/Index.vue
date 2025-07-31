<template>
    <main>
        <Container1024 is="article">
            <LatestArticle :article="articles[0]" />

            <AboutUs class="about-us" />

            <Articles
                v-if="articles.length > 1"
                :articles="articlesWithoutFirstElement()"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
    import Articles from "@/components/Article/Articles.vue";
    import { Pagination } from "@/models/shared/pagination";
    import { computed, onMounted } from "vue";
    import LatestArticle from "@/components/Article/LatestArticle.vue";
    import AboutUs from "@/components/AboutUs.vue";
    import storeArticle from '@/stores/modules/article/index'

    const articleStore = storeArticle()
    async function loadArticles() {
        await articleStore.fetchVisibleArticles(new Pagination(1, 4));
    }

    const articles = computed(() => {
        return articleStore.getVisibleArticles;
    });

    // const articles = computed(() => articleStore.getVisibleArticles)

    function articlesWithoutFirstElement() {
        return articles.value.slice(1);
    }

    onMounted(() => {
        loadArticles();
    })
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
