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
    import { computed, ref, watch } from "vue";
    import { useStore } from "vuex";
    import { useRoute, useRouter } from "vue-router";

    import Articles from "@/components/Article/Articles.vue";
    import { Pagination } from "@/models/shared/pagination";
    import PaginationComponent from "@/components/Article/Pagination.vue";
    import Container1024 from "@/components/Container1024.vue";

    const { dispatch, getters } = useStore();

    const itemsPerPage = 10;

    const route = useRoute();
    const router = useRouter();

    const actualPage = computed<number>({
        get() {
            if (null === route.query.page || typeof route.query.page !== 'number') {

                router.push({path: route.fullPath, query: { page: 1 }});
                return 1;
            }

            let value = parseInt(route.query.page);
            router.push({path: route.fullPath, query: { page: value }});
            return value;
        },
        set(value) {
            router.push({path: route.fullPath, query: { page: value }})
        },
    });

    let articles = computed(() => {
        return getters["article/getVisibleArticles"];
    });

    let total = computed(() => {
        return getters["article/getTotal"];
    });

    watch(actualPage, () => {
        dispatch("article/getVisibleArticles", new Pagination(actualPage.value, itemsPerPage))
    }, { immediate: true });

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
