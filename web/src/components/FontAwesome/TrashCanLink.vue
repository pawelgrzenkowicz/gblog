<template>
    <div>
        <a :href="link" :class="style">
            <font-awesome-icon :icon="['fas', 'trash-can']" />
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

            &.color-seashell {
                color: $seashell;
            }

            &.icon {
                color: yellow;
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
