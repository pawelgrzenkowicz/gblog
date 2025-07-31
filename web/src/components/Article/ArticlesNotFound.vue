<template>
    <article>
        <p>Brak artykułów</p>
    </article>
</template>

<script lang="ts" setup>
</script>

<style lang="scss" scoped>
@import '@/assets/shared/breakpoints';

    @include mobile-S {
        article {
            //justify-content: center;
            background-color: $brown;
            padding: 1rem 0;
            text-align: center;

            p {
                color: $seashell;
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
