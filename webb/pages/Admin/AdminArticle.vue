<template>
    <main>
        <Container1024 is="section">
            <Article
                v-if="article"
                :contents="article.contents"
                :main-picture="article.mainPicture"
                :publication-date="article.publicationDate ?? ''"
                :title="article.title"
            />
            <NotExist
                v-if="!article"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    // import { useStore } from "vuex";
    import { computed, ComputedRef, watch } from "vue";

    import Container1024 from "@/components/Container1024.vue";
    import Article from "@/components/Article/Article.vue";
    import NotExist from "@/components/NotExist.vue";
    import { AdminArticleDetails } from "@/models/article/adminArticleDetails";

    import storeArticle from '@/stores/modules/article/index'

    const props = withDefaults(
        defineProps<{
            slug: string,
        }>(),
        {
            slug: '',
        }
    );

    // const { dispatch, getters } = useStore();

    const articleStore = storeArticle();

    // dispatch("article/getAdminArticleBySlug", props.slug)
    articleStore.fetchAdminArticleBySlug(props.slug)


    let article: ComputedRef<AdminArticleDetails> = computed(() => {
        // return getters["article/getAdminArticleDetails"];
        return articleStore.getAdminArticleDetails
    });

    // watch(article, (new1, old1) => {
    //     console.log(new1);
    //     // console.log(old1);
    // })
</script>

<style lang="scss" scoped>
    @include mobile-S {
        //section {
        //    text-align: center;
        //}
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
