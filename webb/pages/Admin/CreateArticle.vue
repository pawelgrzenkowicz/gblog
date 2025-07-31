<template>
    <main>
        <Container1024 is="article">
            <ArticleManager
                v-model:content-he="contentHe"
                v-model:content-she="contentShe"
                v-model:categories="categories"
                v-model:main-picture-file="mainPictureFile"
                v-model:main-picture-alt="mainPictureAlt"
                v-model:main-picture-name="mainPictureName"
                v-model:main-picture-source="mainPictureName"
                :is-publication-date="false"
                v-model:publication-date="publicationDate"
                v-model:ready="ready"
                v-model:slug="slug"
                v-model:title="title"

                v-model:errors="errors"
                v-model:is-valid="isValid"

                button-text="Dodaj"

                @submitForm="sendRequest"
            />

            <ErrorsComponent
                v-if="errors.length"
                :errors="errors"
            />

            <ErrorsComponent
                v-if="errors2.length"
                :errors="errors2"
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

                message="CREATED"
            />

        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import { computed, onBeforeUnmount, ref, watch } from "vue";
    import { useRouter } from "vue-router";
    // import { useStore } from "vuex";
    import { useRuntimeConfig } from "nuxt/app";

    import { prepare, preparePictureSource } from "@/composables/UseArticleFormData";
    import { Ready } from "@/models/article/ready";
    import ArticleManager from "@/components/Article/ArticleManager.vue";
    import Container1024 from "@/components/Container1024.vue";
    import ErrorsComponent from "@/components/Errors/Errors.vue";
    import ApiErrorsComponent from "@/components/Errors/ApiErrors.vue"
    import { ErrorsObject } from "@/composables/UseErrors";
    import SuccessMessage from "@/components/Success/SuccessMessage.vue";
    import ValidationError from "@/components/Errors/ValidationError.vue";
    // import { mainPicturePath } from "@/config/parameters";
    import { Errors } from "@/models/shared/errors";

    import storeArticle from '@/stores/modules/article/index'

    const articleStore = storeArticle()

    // const { dispatch, getters } = useStore();
    const router = useRouter();
    
    let contentHe = ref<string>(' ')
    let contentShe = ref<string>(' ')
    let categories = ref<string>('')
    let mainPictureAlt = ref<string>('')
    let mainPictureName = ref<string>('')
    let publicationDate = ref<string|null>(null)
    let ready = ref<Ready>(new Ready(false, false))
    let slug = ref<string>('')
    let title = ref<string>('');
    let mainPictureFile = ref<File|null>();

    let errors = ref<Array<string>>([]);
    let errors2 = ref<Array<string>>([]);
    let isValid = ref<boolean>(false);

    const apiErrors = computed<ErrorsObject|null>(() => {
        return articleStore.getErrors;
    });

    const isSuccess = computed<boolean>(() => {
        return articleStore.getIsSuccess
    });

    const validationError = computed<string|null>(() => {
        return articleStore.getValidationError
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
        errors2.value = [];
        if (!isValid.value) {
            return;
        }

        if (!mainPictureFile.value) {
            errors2.value.push(Errors.PICTURE_NOT_FOUND);
            return;
        }

        const form = new FormData;

        const mainPicturePath = useRuntimeConfig().public.MAIN_PICTURE_PATH
        const formData = prepare(
            form,
            contentHe.value,
            contentShe.value,
            mainPictureAlt.value,
            preparePictureSource(mainPicturePath, mainPictureName.value),
            ready.value.he ? '1' : '0',
            ready.value.she ? '1' : '0',
            slug.value,
            title.value,
            categories.value,
            '0',
            '0',
            publicationDate.value ?? '',
            mainPictureFile.value
        )

        articleStore.createArticle(formData)

        // dispatch("article/createArticle", formData)
    }

    watch(isSuccess, (newValue) => {
        if (newValue) {
            setTimeout(() => {
                articleStore.setIsSuccess(false)
                router.push({name: 'admin'});
            }, 2000);
        }
    });

    onBeforeUnmount(() => {
        articleStore.setIsSuccess(false)
    });

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
