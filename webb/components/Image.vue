<template>
    <picture>
        <source v-for="source in srcset" :media="`(min-width:${source[1]}px)`" :srcset="source[0]" />
        <img :src="resizer.resize(src, 'original')" alt="" />
    </picture>
</template>

<script setup lang="ts">
    import { computed } from "vue";
    import { UseImageResize } from "@/composables/UseImageResize";

    const props = withDefaults(
        defineProps<{
            alt: string,
            formats?: string[];
            src: string;
        }>(),
        {
        },
    );

    const resizer = new UseImageResize({
        'small': 320,
        'medium': 768,
        'original': 1024,
    });

    const srcset = computed<Array<[string, number]>>(
        () => resizer.srcset(props.src, props.formats || []),
    );
</script>

<style lang="scss">
    img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
</style>
