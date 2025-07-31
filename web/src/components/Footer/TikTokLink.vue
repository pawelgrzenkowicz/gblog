<template>
    <div class="connect-link">
        <a :href="link" :class="style" target="_blank">
            <font-awesome-icon :icon="['fab', 'tiktok']" />
        </a>
        <span>{{ text }}</span>
    </div>
</template>

<script lang="ts" setup>
    withDefaults(
        defineProps<{
            link: string,
            style: string,
            text: string,
        }>(),
        {
            link: '',
            style: '',
            text: '',
        }
    );
</script>

<style lang="scss" scoped>

    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        a {
            &.color-gb {
                color: $grain_brown;
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
