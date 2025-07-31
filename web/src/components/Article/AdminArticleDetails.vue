<template>
    <article :id="uuid">
        <div class="title">
            <p class="label">Tytuł</p>
            <p>{{title}}</p>
        </div>

        <div class="slug">
            <p class="label">slug</p>
            <p>{{slug}}</p>
        </div>

        <div class="views-number">
            <p class="label">Wyświetlenia</p>
            <p>{{views}}</p>
        </div>


<!--        <div class="comment-number">-->
<!--            <p class="label">Komentarze</p>-->
<!--            <p>123</p>-->
<!--        </div>-->


        <div class="actions">
            <RouterLink
                :class="{'red' : !isVisible}"
                :to="{ name: '_admin_blog_article', params: {slug: slug} }"
                class="color-seashell eye"
            >
                <font-awesome-icon :icon="['fas', 'eye']" />
            </RouterLink>

            <RouterLink
                :to="{ name: '_admin_blog_update_article', params: {uuid: uuid} }"
                class="color-seashell"
            >
                <font-awesome-icon :icon="['fas', 'pen']" />
            </RouterLink>

            <button
                :class="{'red' : isRemoved}"
                @click="softDeleteArticle(uuid)"
                class="color-seashell trash"
            >
                <font-awesome-icon :icon="['fas', 'trash-can']" />
            </button>
        </div>
    </article>
</template>

<script lang="ts" setup>
    import { useStore } from "vuex";

    withDefaults(
        defineProps<{
            uuid: string,
            isRemoved: boolean,
            isVisible: boolean,
            slug: string,
            title: string,
            views: number,
        }>(),
        {
            uuid: '',
            isRemoved: false,
            isVisible: false,
            slug: '',
            title: '',
            views: 0,
        }
    );

    const { dispatch } = useStore();

    function softDeleteArticle(uuid: string) {
        const isDeleted = dispatch("article/deleteArticle", uuid)

        isDeleted.then((result) => {
            if (result) {
                const element = document.getElementById(uuid)!.querySelector('.actions') as HTMLElement;
                element.querySelector('.eye')!.classList.add('red');
                element.querySelector('.trash')!.classList.add('red');
            }
        })
    }

</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        article {
            color: $seashell;
            padding: 5px 0;
            margin: 2rem auto;
            width: 90%;

            div {
                margin: 2rem auto;
                text-align: center;

                &.actions {

                    a, button {
                        &.color-seashell {
                            color: $seashell;
                            font-size: 1.5rem;
                            margin: 16px 30px;
                        }

                        &.red {
                            color: red;
                            font-size: 1.5rem;
                            margin: 16px 30px;
                        }
                    }

                    button {
                        background-color: inherit;
                        border: none;
                        cursor: pointer;
                    }
                }

                p {
                    margin: 0;

                    &.label {
                        margin-bottom: 5px;
                    }
                }
            }
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
