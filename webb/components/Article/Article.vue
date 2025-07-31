<template>
    <article>
        <section class="image">
            <div class="image-container">
                <Image
                    :alt="mainPicture.alt"
                    :formats="['original', 'medium', 'small']"
                    :src="mainPicture.source"
                />
            </div>
        </section>

        <section class="info">
            <h6>{{ showDate(publicationDate) }}</h6>
            <h1>{{ title }}</h1>

            <div>
                <button @click="setAuthor(Author.she)" class="she-button" :class="{'selected' : activeAuthor === 'she'}">Sandra</button>
                <button @click="setAuthor(Author.he)" class="he-button" :class="{'selected' : activeAuthor === 'he'}">Paweł</button>
            </div>
        </section>

        <section
            v-html="activeAuthor === Author.she ? contents.she : contents.he"
            class="content"
        >
        </section>
    </article>
</template>

<script lang="ts" setup>

    import { onMounted, ref } from "vue";

    import { Author } from "@/models/article/author";
    import { showDate } from "@/composables/UseTextModifier";
    import { Contents } from "@/models/article/contents";
    import Image from "@/components/Image.vue";
    import { Picture } from "@/models/article/picture";

    let styles = 'figcaptiom {font-size:30px}';

    const props = withDefaults(
        defineProps<{
            contents: Contents,
            mainPicture: Picture,
            publicationDate: string,
            title: string,
        }>(),
        {
            contents: () => new Contents('', ''),
            mainPicture: () => new Picture('', '', ''),
            publicationDate: '',
            title: ''
        }
    );

    const activeAuthor = ref('she');

    function setAuthor(author: string) {
      activeAuthor.value = author;
    }


    function changeImageSizeOnMobile() {
        const images = document.querySelectorAll('p img');
        images.forEach((img: any) => {
            img.style.width = '100%';
        })
    }

    onMounted(() => {
        if (window.innerWidth < 768) {
            changeImageSizeOnMobile();
        }
    })

</script>

<style lang="scss" scoped>


    @include mobile-S {
        article {
            background-color: $seashell;
            box-shadow: 0 0 10px $brown;
            color: $brown;
            padding-bottom: 20px;
            margin: 20px auto 20px auto;
            //text-align: center;
            width: 90%;

            section {

                word-wrap: break-word;

                &.image {
                    div {
                        &.image-container {
                            aspect-ratio: 16 / 9;
                            overflow: hidden;
                            width: 100%;
                        }
                    }
                }

                &.info {
                    text-align: center;
                    margin-bottom: 20px;

                    h1 {
                        color: $brown;
                        font-size: 2rem;
                    }

                    h6 {
                        color: $brown;
                    }

                    div {
                        button {
                            border: none;
                            border-radius: 12px;
                            padding: 10px;
                            margin: 0 20px;
                            text-align: center;
                            text-decoration: none;

                            &.he-button {
                                //background-color: $brown;
                                background-color: $grain_brown;
                                color: $seashell;
                            }

                            &.she-button {
                                background-color: $grain_brown;
                                color: $seashell;
                            }

                            &.selected {
                                background-color: $brown
                            }
                        }
                    }
                }

                &.content {
                    font-size: 1em;
                    padding: 20px;

                    //:deep figcaption {
                    :deep(figcaption) {
                        font-size: 0.6em;
                        color: $extra_dark_brown;
                        text-align: center;
                    }

                    //:deep {
                    //    .image {
                    //        margin: .9em auto;
                    //    }
                    //
                    //    figure {
                    //        margin: unset;
                    //        all: unset;
                    //    }
                    //}


                    :deep(.image) {
                        margin: 0.9em auto;
                    }

                    :deep(figure) {
                        margin: unset;
                        all: unset;
                    }

                    //:deep a {
                    //    color: inherit;
                    //    text-decoration: none;
                    //}

                    :deep(a) {
                        color: inherit;
                        text-decoration: none;
                    }

                    :deep(blockquote) {
                        border-left: 5px solid #ccc;
                        font-style: italic;
                        margin-left: 0;
                        margin-right: 0;
                        overflow: hidden;
                        padding-left: 1.5em;
                        padding-right: 1.5em;
                    }

                    //:deep blockquote {
                    //    border-left: 5px solid #ccc;
                    //    font-style: italic;
                    //    margin-left: 0;
                    //    margin-right: 0;
                    //    overflow: hidden;
                    //    padding-left: 1.5em;
                    //    padding-right: 1.5em;
                    //}
                }
            }
        }
    }

    @include mobile-M {

    }

    @include mobile-L {

    }

    @include tablet {
        article {

            section {

                //&.content {
                //    :deep figcaption {
                //        font-size: 0.8em;
                //    }
                //
                //    :deep {
                //        figure {
                //            all: revert;
                //            margin: unset;
                //
                //            &.image-style-side {
                //                margin-top: 0;
                //                max-width: 50%;
                //                float: right;
                //                margin-left: var(--ck-image-style-spacing);
                //            }
                //
                //            &.image.image_resized {
                //                max-width: 100%;
                //            }
                //        }
                //    }
                //}

                &.content {
                    :deep(figcaption) {
                        font-size: 0.8em;
                    }

                    :deep(figure) {
                        all: revert;
                        margin: unset;

                        &.image-style-side {
                            margin-top: 0;
                            max-width: 50%;
                            float: right;
                            margin-left: var(--ck-image-style-spacing);
                        }

                        &.image.image_resized {
                            max-width: 100%;
                        }
                    }
                }
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

    }


</style>
