<template>
    <picture>
        <source v-for="source in srcset" :media="`(min-width:${source[0]}px)`" :srcset="source[1]" />
        <img :src="originalImage" :alt="props.alt" />
    </picture>
</template>

<script setup lang="ts">
    const props = withDefaults(
        defineProps<{
            alt: string,
            originalImage: string;
            smallImage: string;
            mediumImage: string
        }>(),
        {
        },
    );

    const srcset = <Array<[number, string]>>[
        [
            1024, props.originalImage
        ],
        [
            768, props.mediumImage
        ],
        [
            320, props.smallImage,
        ],
    ];
</script>

<style lang="scss">
    img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
</style>
