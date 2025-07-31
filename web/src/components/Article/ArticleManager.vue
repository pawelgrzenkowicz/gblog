<template>
    <section>
        <form @submit.prevent="">
            <div class="main-data">
                <div>
                    <input v-model="title" placeholder="tytuł">
                </div>
                <div>
                    <input v-model="slug" placeholder="slug" @input="handleSlug">
                </div>
                <div>
                    <input v-model="categories" placeholder="kategorie" @input="handleCategories">
                </div>
                <div>
                    <label class="date-checkbox">Data publikacji</label>
                    <input v-model="isPublicationDate" type="checkbox" class="checkbox">
                </div>
                <input v-if="isPublicationDate" v-model="publicationDate" type="datetime-local">
            </div>

            <div class="author">
                <div class="content">
                    <div>
                        <label for="readyShe">Sandra gotowa</label>
                        <input v-model="ready.she" type="checkbox" id="readyShe" class="checkbox">
                    </div>
                    <div>
                        <label for="readyHe">Paweł gotowy</label>
                        <input v-model="ready.he" type="checkbox" id="readyHe" class="checkbox">
                    </div>
                    <div>
                        <button
                            :onclick="changeAuthor"
                            class="author-btn"
                        >
                            Autor {{ authorName }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="image-data">
                <div class="content">
                    <input
                        @change="setMainPicture"
                        accept="image/png, image/jpg, image/jpeg"
                        id="mainPicture"
                        ref="fileInput"
                        style="display: none"
                        type="file"
                    >
                    <button @click="fileInput?.click()">
                        Wybierz zdjęcie główne
                    </button>
                    <div>
                        <input
                            v-model="mainPictureName"
                            placeholder="Nazwa zdjęcia"
                            @input="handleMainPictureName"
                        >
                    </div>
                    <div>
                        <input
                            v-model="mainPictureAlt"
                            placeholder="Alt zdjęcia"
                        >
                    </div>
                </div>
            </div>
        </form>

        <section class="image-view">
            <img id="mainImage" />
        </section>

        <WYSIWYG
            v-model="activeContent"
        >
        </WYSIWYG>

        <div class="add-button">
            <button @click="validateAndSend">{{ buttonText }}</button>
        </div>
    </section>
</template>

<script lang="ts" setup>
    import { computed, ComputedRef, onBeforeUnmount, onMounted, ref, watch } from "vue";
    import { useStore } from "vuex";

    import { IMAGE_HOST } from "../../../config/parameters";
    import WYSIWYG from "@/components/Article/WYSIWYG.vue";
    import { Errors } from "@/models/shared/errors";
    import { Ready } from "@/models/article/ready";
    import { replaceUnnecessaryCharacters } from "@/composables/UseTextModifier";

    const props = withDefaults(
        defineProps<{
            contentHe: string,
            contentShe: string,
            categories: string,
            mainPictureFile: File|null,
            mainPictureAlt: string,
            mainPictureName: string,
            mainPictureSource: string,
            isPublicationDate: boolean,
            publicationDate: string|null,
            ready: Ready,
            slug: string,
            title: string,

            errors: Array<string>|null,
            isValid: boolean,

            buttonText: string
        }>(),
        {
            contentHe: '',
            contentShe: '',
            categories: '',
            mainPictureFile: null,
            mainPictureAlt: '',
            mainPictureName: '',
            mainPictureSource: '',
            isPublicationDate: false,
            publicationDate: null,
            ready: () => new Ready(false, false),
            slug: '',
            title: '',

            errors: null,
            isValid: false,

            buttonText: 'Dodaj',
        }
    );

    const author = ref<string>('she')
    const authorName = ref<string>('Sandra')
    const contentHe = ref(props.contentHe);
    const contentShe = ref(props.contentShe);
    const categories = ref<string>(props.categories);
    const fileInput = ref<HTMLInputElement>();
    const mainPictureFile = ref<File|null>();
    const mainPictureAlt = ref<string>(props.mainPictureAlt);
    const mainPictureName = ref<string>(props.mainPictureName);
    const mainPictureSource = ref<string>(props.mainPictureSource);
    const isPublicationDate = ref<boolean>(props.isPublicationDate);
    const publicationDate = ref<string|null>(props.publicationDate);
    const ready = ref<Ready>(new Ready(props.ready.he, props.ready.she));
    const slug = ref<string>(props.slug);
    const title = ref<string>(props.title);

    const errors = ref<Array<string>|null>(props.errors);
    const isValid = ref<boolean>(props.isValid);

    const emits = defineEmits([
        'update:contentHe',
        'update:contentShe',
        'update:categories',
        'update:mainPictureFile',
        'update:mainPictureAlt',
        'update:mainPictureName',
        'update:publicationDate',
        'update:ready',
        'update:slug',
        'update:title',

        'update:errors',
        'update:isValid',

        'submitForm',
    ]);

    watch(contentHe, (value) => {
        emits('update:contentHe', value);
    });

    watch(contentShe, (value) => {
        emits('update:contentShe', value);
    });

    watch(categories, (value) => {
        emits('update:categories', value);
    });

    watch(mainPictureFile, (value) => {
        emits('update:mainPictureFile', value);
    });

    watch(mainPictureAlt, (value) => {
        emits('update:mainPictureAlt', value);
    });

    watch(mainPictureName, (value) => {
        emits('update:mainPictureName', value);
    });

    watch(publicationDate, (value) => {
        emits('update:publicationDate', value);
    });

    watch(ready.value, (value) => {
        emits('update:ready', value);
    });

    watch(slug, (value) => {
        emits('update:slug', value);
    });

    watch(title, (value) => {
        emits('update:title', value);
    });

    watch(errors, (value) => {
        emits('update:errors', value);
    });

    watch(isValid, (value) => {
        emits('update:isValid', value);
    });

    const activeContent = computed<string>({

        get: () => {
            switch (author.value) {
                case 'she':
                    return contentShe.value;

                case 'he':
                    return contentHe.value;

                default:
                    throw new Error();
            }
        },
        set: (value) => {
            switch (author.value) {
                case 'she':
                    contentShe.value = value;
                    break;

                case 'he':
                    contentHe.value = value;
                    break;

                default:
                    throw new Error();
            }
        },
    })

    function changeAuthor(): void {
        if (author.value === 'she') {
            author.value = 'he';
            authorName.value = 'Paweł'
        } else {
            author.value = 'she';
            authorName.value = 'Sandra';
        }
    }

    const validateAndSend = () => {
        errors.value = [];

        let validSlug: boolean = true;
        let validTitle: boolean = true;
        // let validPictureFile: boolean = true;
        let validPictureAlt: boolean = true;
        let validPictureName: boolean = true;

        if (slug.value.length <= 0) {
            errors.value?.push(Errors.SLUG_VALUE_TOO_SHORT)
            validSlug = false;
        }

        if (title.value.length <= 0) {
            errors.value?.push(Errors.TITLE_VALUE_TOO_SHORT)
            validTitle = false;
        }

        if (mainPictureAlt.value.length <= 0) {
            errors.value?.push(Errors.PICTURE_ALT_VALUE_TOO_SHORT)
            validPictureAlt = false;
        }

        if (mainPictureName.value.length <= 0) {
            errors.value?.push(Errors.PICTURE_NAME_VALUE_TOO_SHORT)
            validPictureName = false;
        }

        isValid.value = (validSlug && validTitle && validPictureAlt && validPictureName);

        emits('update:isValid', isValid.value);

        emits('submitForm');
    };

    function handleCategories() {
        categories.value = props.categories.replace(/\s/g, '');

        const commaCount = (categories.value.match(/,/g) || []).length;
        if (commaCount > 2) {
            let commas = 0;
            let text = '';

            for (let i = 0; i < categories.value.length; i++) {
                if (categories.value[i] === ',') {
                    commas++;
                    if (commas >= 3) {
                        text += '';
                        continue;
                    }
                }

                text += categories.value[i];
            }

            categories.value = text;
        }
    }

    function handleMainPictureName() {
        replaceUnnecessaryCharacters(mainPictureName);
    }

    function handleSlug() {
        replaceUnnecessaryCharacters(slug);
    }

    function setMainPicture(event: Event) {
        mainPictureFile.value = (event.target as HTMLInputElement).files!.item(0);

        let image: HTMLImageElement = document.getElementById('mainImage') as HTMLImageElement;
        if (mainPictureFile.value) {
            image.src = URL.createObjectURL(mainPictureFile.value)
        }
    }

    onMounted(async () => {
        if (mainPictureName.value) {
            let imageElement: HTMLImageElement = document.getElementById('mainImage') as HTMLImageElement;
            const url = `${IMAGE_HOST}/original/${mainPictureSource.value}`;
            imageElement.src = url;
        }
    })

    onBeforeUnmount(() => {
        const { dispatch } = useStore();

        dispatch("article/setAdminArticleDetails", null)
    });


// watch(ready.value, (new1, old1) => {
//     console.log('weszło');
//     console.log(new1);
//     // console.log(new1.length);
// })


</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        //main {
        //    font-family: $article_font;
        //    margin: 20px 0 20px 0;
        //    text-align: center;

            //section {

                form {
                    display: flex;
                    flex-flow: column;
                    margin-bottom: 20px;
                    div {
                        &.main-data {
                            background-color: $brown;
                            order: 1;
                            padding: 15px;
                            margin: 5px 0;

                            input:focus+label {
                                font-family: $article_font;
                                color: #ffffff;
                            }
                        }
                        &.author {
                            order: 3;
                            background-color: $brown;
                            padding: 15px;
                            position: relative;
                            margin: 5px 0;

                            div {
                                .author-btn {
                                    background-color: $grain_brown;
                                    border: none;
                                    border-radius: 12px;
                                    color: $seashell;
                                    font-family: $article_font;
                                    padding: 10px;
                                    margin: 20px 0 0 0;
                                    text-align: center;
                                    text-decoration: none;
                                }
                            }
                        }

                        &.image-data {
                            order: 2;
                            background-color: $brown;
                            padding: 15px;
                            margin: 5px 0;
                            position: relative;

                            div {
                                button {
                                    background-color: $grain_brown;
                                    border: none;
                                    border-radius: 12px;
                                    color: $seashell;
                                    font-family: $article_font;
                                    padding: 10px;
                                    margin: 0 0 10px 0;
                                    text-align: center;
                                    text-decoration: none;
                                }
                            }
                        }
                    }

                    input {
                        background-color: $grain_brown;
                        font-family: $article_font;
                        margin: 5px 0;

                        &::placeholder {
                            color: $brown;
                            font-family: $article_font;
                        }
                        &.checkbox {
                            accent-color: $grain_brown;
                            margin-left: 5px;
                        }
                    }

                    label {
                        color: $grain_brown;
                        font-family: $article_font;
                    }
                }
            //}

            section {
                &.image-view {
                    aspect-ratio: 16 / 9;
                    overflow: hidden;
                    width: 100%;
                    margin-bottom: 50px;

                    img {
                        border: 1px solid $brown;
                        min-height: 20px;
                    }
                }
            }

            div {
                &.add-button {
                    margin: 20px 0;
                    button {
                        background-color: $grain_brown;
                        border: none;
                        border-radius: 12px;
                        color: black;
                        cursor: pointer;
                        font-family: $article_font;
                        font-size: 1rem;
                        padding: 10px;
                        margin: 0 0 10px 0;
                        text-align: center;
                        text-decoration: none;
                    }
                }
            }


        //}
    }

    @include mobile-M {

    }

    @include mobile-L {

    }

    @include tablet {
        //main {
        //    section {
                form {
                    display: flex;
                    flex-flow: nowrap;
                    justify-content: center;
                    margin-bottom: 50px;
                    div {
                        &.main-data {
                            display: inline-block;
                            height: 180px;
                            margin: 0 10px;
                            order: 1;
                            width: 15rem;
                        }
                        &.author {
                            display: inline-block;
                            height: 180px;
                            margin: 0 20px;
                            order: 2;
                            width: 15rem;
                        }
                        &.image-data {
                            display: inline-block;
                            height: 180px;
                            margin: 0 20px;
                            order: 3;
                            width: 15rem;
                        }
                    }

                }

            }
    //    }
    //}

    @include laptop {

    }

    @include laptop-L {

    }
</style>
