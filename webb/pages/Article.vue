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
    import { computed, onMounted } from "vue";

    import Container1024 from "@/components/Container1024.vue";
    import Article from "@/components/Article/Article.vue";
    import NotExist from "@/components/NotExist.vue";

    import storeArticle from '@/stores/modules/article/index'

    const props = withDefaults(
        defineProps<{
            slug: string,
        }>(),
        {
            slug: '',
        }
    );

    const articleStore = storeArticle();

    async function loadArticle() {
        await articleStore.fetchVisibleArticleBySlug(props.slug);
    }

    const article = computed(() => {
        return articleStore.getVisibleArticle;
    });

    onMounted(() => {
        loadArticle();
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
