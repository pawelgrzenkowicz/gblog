<template>
    <section class="api-success">
        <article>
            <p>{{ $t('success.' + message) }}</p>
        </article>
    </section>
</template>

<script lang="ts" setup>

    const props = defineProps<{
        message: string,
    }>();
</script>

<style lang="scss" scoped>


    @include mobile-S {
        section {
            &.api-success {
                article {
                    background-color: $grain_brown;
                    max-width: 500px;
                    margin: 0 auto;

                    p {
                        color: $success;
                        margin: 0;
                        padding: 5px 0;
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
