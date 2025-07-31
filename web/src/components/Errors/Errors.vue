<template>
    <section class="api-errors">
        <article
            v-for="error in errors"
        >
            <p>{{ $t('errors.' + error) }}</p>
        </article>
    </section>
</template>

<script lang="ts" setup>
    import { ErrorsObject } from "@/composables/UseErrors";

    const props = defineProps<{
            errors: Array<string>,
        }>();
</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        section {
            &.api-errors {
                article {
                    background-color: $grain_brown;
                    max-width: 500px;
                    margin: 0 auto;

                    p {
                        flex: 1;
                        color: $redError;
                        margin: 0;
                        padding: 5px 0;
                        text-align: center;
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
