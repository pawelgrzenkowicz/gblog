<template>
    <main>
        <Container1024 is="article">
            <Articles :articles="articles" />

            <PaginationComponent
                :items-per-page="itemsPerPage"
                :total="total"
                v-model="actualPage"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { computed, onMounted, ref, watch } from "vue";
    import { useRoute, useRouter } from "vue-router";

    import Articles from "@/components/Article/Articles.vue";
    import { Pagination } from "@/models/shared/pagination";
    import PaginationComponent from "@/components/Article/Pagination.vue";
    import Container1024 from "@/components/Container1024.vue";
    import storeArticle from "@/stores/modules/article/index"
    import { usePageQuery } from "@/composables/usePageQuery";

    const articleStore = storeArticle()
    // const itemsPerPage = 10;
    const itemsPerPage = 2;

    const { actualPage } = usePageQuery();

    const articles = computed(() => {
        return articleStore.getVisibleArticles
    });

    const total = computed(() => {
        return articleStore.getTotal
    });

    watch(actualPage, () => {
        articleStore.fetchVisibleArticles(new Pagination(actualPage.value, itemsPerPage))
    }, { immediate: true });

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
