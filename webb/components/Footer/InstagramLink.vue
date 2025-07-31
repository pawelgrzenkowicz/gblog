<template>
    <div class="connect-link">
        <a :href="link" :class="style" target="_blank">
            <FontAwesomeIcon :icon="['fab', 'instagram']" />
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
