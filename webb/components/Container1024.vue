<template>
    <Component :is="is" class="container">
        <slot />
    </Component>
</template>

<script lang="ts" setup>
    withDefaults(
        defineProps<{
            is?: string,
            width?: number,
        }>(),
        {
            is: 'div',
            width: 1024,
        },
    )
</script>

<style lang="scss" scoped>


    .container {
        margin: 0 auto;
        width: 100%;

        @include for(1024px) {
            max-width: 1024px;
        }
    }
</style>
