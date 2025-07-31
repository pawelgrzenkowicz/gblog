<template>
    <main>
        <Container1024 is="article">
            <ArticleManager
                v-if="article"
                v-model:content-he="article.contents.he"
                v-model:content-she="article.contents.she"
                v-model:categories="article.categories"
                v-model:main-picture-file="mainPictureFile"
                v-model:main-picture-alt="article.mainPicture.alt"
                v-model:main-picture-name="article.mainPictureName"
                v-model:main-picture-source="article.mainPicture.source"
                :is-publication-date="!!article.publicationDate"
                v-model:publication-date="article.publicationDateFormatted"
                v-model:ready="article.ready"
                v-model:slug="article.slug"
                v-model:title="article.title"

                v-model:errors="errors"
                v-model:is-valid="isValid"

                button-text="Edytuj"

                @submitForm="sendRequest"
            />

            <ErrorsComponent
                v-if="errors.length"
                :errors="errors"
            />

            <ApiErrorsComponent
                v-if="apiErrors"

                :api-errors="apiErrors"
            />

            <ValidationError
                v-if="validationError"

                :message="validationError"
            />

            <SuccessMessage
                v-if="isSuccess"

                message="UPDATED"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { computed, ComputedRef, onBeforeUnmount, onMounted, ref, watch } from "vue";

    import ArticleManager from "@/components/Article/ArticleManager.vue";
    import Container1024 from "@/components/Container1024.vue";
    import { prepare, preparePictureSource } from "@/composables/UseArticleFormData";
    import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
    import ErrorsComponent from "@/components/Errors/Errors.vue";
    import ApiErrorsComponent from "@/components/Errors/ApiErrors.vue";
    import ValidationError from "@/components/Errors/ValidationError.vue";
    import SuccessMessage from "@/components/Success/SuccessMessage.vue";
    import { ErrorsObject } from "@/composables/UseErrors";
    import storeArticle from '@/stores/modules/article/index'
    import { useRuntimeConfig } from "nuxt/app";

    const props = withDefaults(
        defineProps<{
            uuid: string,
        }>(),
        {
            uuid: '',
        }
    );

    // const { dispatch, getters } = useStore();

    const articleStore = storeArticle();

    // dispatch("article/getAdminArticleByUuid", props.uuid)

    const article = computed(() => {
        return articleStore.getAdminArticleDetails
    });

    // let article = computed<AdminArticleDetails>(() => {
    //     return getters["article/getAdminArticleDetails"];
    // });

    let mainPictureFile = ref<File|null>(null);

    let errors = ref<Array<string>>([]);
    let isValid = ref<boolean>(false);

    let apiErrors = computed<ErrorsObject|null>(() => {
        return articleStore.getErrors
        // return getters["article/getErrors"];
    });

    let isSuccess = computed<boolean>(() => {
        return articleStore.getIsSuccess
        // return getters["article/getIsSuccess"];
    });

    let validationError = computed<string|null>(() => {
        return articleStore.getValidationError
        // return getters["article/getValidationError"];
    });

    // let apiErrors = computed<ErrorsObject|null>(() => {
    //     return getters["article/getErrors"];
    // });
    //
    // let isSuccess = computed<boolean>(() => {
    //     return getters["article/getIsSuccess"];
    // });
    //
    // let validationError = computed<string|null>(() => {
    //     return getters["article/getValidationError"];
    // });

    function sendRequest() {
        if (!isValid.value) {
            return;
        }

        if (!article.value) {
            return;
        }

        const mainPicturePath = useRuntimeConfig().public.MAIN_PICTURE_PATH
        if (typeof mainPicturePath !== 'string') {
            return;
        }

        const form = new FormData;

        const formData = prepare(
            form,
            article.value.contents.he,
            article.value.contents.she,
            article.value.mainPicture.alt,
            preparePictureSource(mainPicturePath, article.value.mainPictureName),
            article.value.ready.he ? '1' : '0',
            article.value.ready.she ? '1' : '0',
            article.value.slug,
            article.value.title,
            article.value.categories,
            article.value.views.toString(),
            article.value.removed ? '1' : '0',
            article.value.publicationDateFormatted ?? '',
            mainPictureFile.value
        );

        // formData.append('mainPictureOld[alt]', article.value.mainPicture.alt);
        // formData.append('mainPictureOld[source]', article.value.mainPicture.source);
        // formData.append('mainPictureOld[extension]', article.value.mainPicture.extension);

        // dispatch("article/updateArticle", {uuid: props.uuid, formData: formData})
        articleStore.updateArticle({uuid: props.uuid, formData: formData})
    }

    onMounted(() => {
        articleStore.fetchAdminArticleByUuid(props.uuid)
    })

    onBeforeUnmount(() => {
        // dispatch("article/setIsSuccess", false);
        articleStore.setIsSuccess(false)
    });

    watch(isSuccess, (newValue) => {
        if (newValue) {
            setTimeout(() => {
                // dispatch("article/setIsSuccess", false)
                articleStore.setIsSuccess(false)
            }, 4000);
        }
    });

    // watch(article, (new1, old1) => {
    //
    //     console.log(new1);
    // })
</script>

<style lang="scss" scoped>
    @include mobile-S {
        main {
            font-family: $article_font;
            margin: 20px 0 20px 0;
            text-align: center;
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
