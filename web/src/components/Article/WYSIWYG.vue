<template>
    <ImageFileModal
        v-model:show="imageFileModalOpened"
        v-model:data="imageFileData"
    />

    <div class="toolbar" ref="toolbarContainer"></div>
    <ckeditor
        :editor="editor"
        :config="editorConfig"
        @ready="onReady"

        v-model:modelValue="content"
        @update:modelValue="onUpdateContent"
    ></ckeditor>
</template>

<script lang="ts" setup>
    import { ref, watch } from "vue";
    import { useStore } from "vuex";
    import ImageFileModal from '@/components/ImageFileModal.vue';
    import '@vueup/vue-quill/dist/vue-quill.snow.css';

    import { preparePictureSource } from "@/composables/UseArticleFormData";
    import { IMAGE_HOST, articleContentPicturePath } from "../../../config/parameters";


    import DecoupledEditor from "@ckeditor/ckeditor5-build-decoupled-document";
    import i18n from "@/i18n";


    const imageFileModalOpened = ref<boolean>(false);
    const imageFileData = ref<object|null>(null);


    function watchImageData() {
        return new Promise(
            (resolve, reject) => {
                imageFileModalOpened.value = true;
                imageFileData.value = null;


                const interval = setInterval(
                    () => {
                        if (imageFileModalOpened.value === false) {
                            resolve(imageFileData.value);
                            clearInterval(interval)
                        }
                    },
                    100,
                );
            },
        );
    }


    class MyUploadAdapter {
        public loader: any;
        public t: any;

        constructor(loader: any) {
            this.loader = loader;
            this.t = i18n;
        }

        async upload() {
            const file = await this.loader.file;
            const data: any = await watchImageData();

            if (data === null) {
                this.abort();
            }

            const formData = new FormData();
            formData.append('picture', file);

            const source = preparePictureSource(articleContentPicturePath, data.name);

            formData.append('source', source);
            formData.append('alt', data.alt);

            let location = await dispatch('article/addPicture', formData)

            if (!location) {
                this.abort();
            }

            const originalSource = `${IMAGE_HOST}/${location}`;

            return {
                default: originalSource,
                320: originalSource.replace('original', 'small'),
                768: originalSource.replace('original', 'medium'),
                1024: originalSource,
            };
        }

        abort() {
            throw new Error(this.t.global.t('message.SAVE_IMAGE_ERROR'));
        }
    }



    function MyCustomUploadAdapterPlugin(editor: any) {
        editor.plugins.get( 'FileRepository' ).createUploadAdapter = (loader: any) => {
            return new MyUploadAdapter(loader);
        };
    }

    const editor = DecoupledEditor;
    const editorConfig: any = {
        extraPlugins: [
            MyCustomUploadAdapterPlugin,
        ],
        toolbar: {
            items: [
                'undo', 'redo',  '|',
                'bold', 'italic', 'underline', 'strikethrough', '|',
                'alignment', '|',
                'heading', '|', 'bulletedList', 'numberedList', 'blockQuote', '|',
                'imageUpload', 'link', 'mediaEmbed', '|',
                'outdent', 'indent',
                'fontFamily', 'fontSize', 'fontColor', 'fontBackgroundColor'
            ],
        },

        image: {
            resizeUnit: '%',
            toolbar: [
                'imageStyle:inline',
                'imageStyle:block',
                'imageStyle:side',
                'toggleImageCaption',
                'resizeImage',
            ]
        },
        mediaEmbed: {
            previewsInData: true,
        },
        link: {
            addTargetToExternalLinks: true,
        },
        indentBlock: {
            offset: 1,
            unit: 'em'
        },
        fontFamily: {
            options: [
                'default',
                'Roxborough-CF',
                'Cormorant Garamond',
                'Open Sans',
                'Roboto'
            ],
            supportAllValues: true,
        },
        fontSize: {
            options: [ '0.5em', '0.75em', '1em', '2em', '3em', '4em' ].map( val => ({
                model: val,
                title: `x${ val }`,
                view: {
                    name: 'span',
                    styles: {
                        'font-size': `${ val }`
                    }
                }
            }) ),
            supportAllValues: true
        },
        fontColor: {
            colors: [
                {
                    color: '#ff0000',
                    label: 'Red'
                },
                {
                    color: '#ffff00',
                    label: 'Yellow'
                },
                {
                    color: '#0000ff',
                    label: 'Blue'
                },
                {
                    color: '#008000',
                    label: 'Green'
                },
                {
                    color: '#ffffff',
                    label: 'White'
                },
                {
                    color: '#000000',
                    label: 'Black'
                },
            ]
        },
        fontBackgroundColor: {
            colors: [
                {
                    color: '#ff0000',
                    label: 'Red'
                },
                {
                    color: '#ffff00',
                    label: 'Yellow'
                },
                {
                    color: '#0000ff',
                    label: 'Blue'
                },
                {
                    color: '#008000',
                    label: 'Green'
                },
                {
                    color: '#ffffff',
                    label: 'White'
                },
                {
                    color: '#000000',
                    label: 'Black'
                },
            ]
        },
    };

    const toolbarContainer = ref<HTMLDivElement|null>(null);

    function onReady(editor: any) {
        if (toolbarContainer.value !== null) {
            toolbarContainer.value.appendChild(editor.ui.view.toolbar.element);
        }
    }


    const { dispatch, getters } = useStore();

    const props = defineProps<{
        modelValue: string,
    }>()

    const content = ref();
    const emit = defineEmits(['update:modelValue'])

    function onUpdateContent() {
        emit('update:modelValue', content.value)
    }

    watch(
        () => props.modelValue,
        (m) => {
            content.value = m;
        },
        { immediate: true }
    );

</script>

<style lang="scss">
    // remove scoped for change default font family
    @import '@/assets/shared/breakpoints';

    div {
        .toolbar {
            border-top: 1px solid $grain_brown;
            border-right: 1px solid $grain_brown;
            border-left: 1px solid $grain_brown;
        }
    }

    .ck {
        font-family: $article_font;
        color: $brown;

        a {
            color: inherit;
            text-decoration: none;
        }

        //img {
        //    max-height: 200px;
        //    width: auto;
        //}
    }

    .ck-editor__editable_inline {
        border: 1px solid $grain_brown !important;
    }

    .ck-toolbar {
        border: none !important;
    }

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
