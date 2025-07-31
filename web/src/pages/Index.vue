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
    import { useStore } from "vuex";
    import { Pagination } from "@/models/shared/pagination";
    import { computed } from "vue";
    import LatestArticle from "@/components/Article/LatestArticle.vue";
    import AboutUs from "@/components/AboutUs.vue";

    const { dispatch, getters } = useStore();

    dispatch("article/getVisibleArticles", new Pagination(1, 4))

    let articles = computed(() => {
        return getters["article/getVisibleArticles"];
    });

    function articlesWithoutFirstElement() {
        return articles.value.slice(1);
    }


</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

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
