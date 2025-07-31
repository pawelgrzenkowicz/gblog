<template>
    <section class="api-errors">
        <article
            v-for="(errorIndex, index) in apiErrors"
        >
            <div class="record">
                <p>{{ $t('fields.' + index) }}:</p>
                <ul class="error-messages">
                    <li v-for="errorMessage in errorIndex.errors">{{ $t('errors.' + errorMessage.message)}}</li>
                </ul>
            </div>
        </article>
    </section>
</template>

<script lang="ts" setup>
    import { ErrorsObject } from "@/composables/UseErrors";

    const props = defineProps<{
            apiErrors: ErrorsObject,
        }>();

    console.log(props.apiErrors);
</script>

<style lang="scss" scoped>


    @include mobile-S {
        section {
            &.api-errors {
                article {
                    background-color: $grain_brown;
                    max-width: 500px;
                    margin: 0 auto;
                    div {
                        &.record {
                            //margin: 10px;
                            padding: 5px 0;
                            display: flex;
                            flex: 1;
                            p {
                                flex: 1;
                                color: $redError;
                                margin: 0;
                                text-align: right;
                            }

                            ul {
                                &.error-messages {
                                    color: $redError;
                                    margin: 0;
                                    padding-inline-start: 25px;
                                    text-align: left;
                                    flex: 1;
                                    li {
                                        //text-indent: -10px;
                                    }
                                }
                            }
                        }
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
