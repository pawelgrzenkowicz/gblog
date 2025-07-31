<template>
    <main>
        <Container1024 is="article">
            <section>
                <Article
                    v-if="article"
                    :contents="article.contents"
                    :main-picture="article.mainPicture"
                    :main-picture-source="article.mainPicture.source"
                    :main-picture-alt="article.mainPicture.alt"
                    :publication-date="article.publicationDate ?? ''"
                    :title="article.title"
                />
                <NotExist
                    v-if="!article"
                />
            </section>
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { useStore } from "vuex";
    import { computed, ComputedRef, watch } from "vue";

    import Container1024 from "@/components/Container1024.vue";
    import { VisibleArticle } from "@/models/article/visibleArticle";
    import Article from "@/components/Article/Article.vue";
    import NotExist from "@/components/NotExist.vue";

    const props = withDefaults(
        defineProps<{
            slug: string,
        }>(),
        {
            slug: '',
        }
    );

    const { dispatch, getters } = useStore();

    dispatch("article/getVisibleArticleBySlug", props.slug)

    let article: ComputedRef<VisibleArticle> = computed(() => {
        return getters["article/getVisibleArticle"];
    });

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
