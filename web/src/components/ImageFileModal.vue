<template>
    <div class="image-file-modal" :class="{ show }">
        <div class="box">
            <button @click="close">X</button>
            <br/>
            <label>
                Nazwa: <input v-model="data.name" @input="handleMainPictureName" />
            </label>
            <br/>
            <label>
                Alt: <input v-model="data.alt" />
            </label>
            <br/>
            <button @click="submit" :disabled="isSubmitDisabled">Zapisz</button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed, ref, watch } from 'vue';

    const props = withDefaults(
        defineProps<{
            data: object|null,
            show: boolean,
        }>(),
        {
            data: null,
            show: false,
        },
    );

    interface Data {
        alt: string;
        name: string;
    }

    const data = ref<Data>({
        alt: '',
        name: '',
    });

    const isSubmitDisabled = computed<boolean>(() => {
        return !data.value.name.trim() || !data.value.alt.trim();
    });

    function handleMainPictureName() {
        if (data.value.name) {
            data.value.name = data.value.name.replace(/\s/g, '');
            data.value.name = data.value.name.toLowerCase();
            data.value.name = data.value.name.replace(/[ąćęłńóśźż]/g, '');

            const regexSpecialCharacters = /[!"#$%&'()*+,./:;<=>?@[\\\]^_{|}]/g;

            data.value.name = data.value.name.replace(regexSpecialCharacters, '');
        }
    }

    const emits = defineEmits(['update:show', 'update:data']);

    const submit = () => {
        if (!isSubmitDisabled.value) {
            emits('update:data', data.value);
            emits('update:show', false);
        }
    };

    const close = () => {
        emits('update:data', null);
        emits('update:show', false);
    };

    watch(() => props.data, () => {
        const newData: any = props.data || {};

        data.value = {
            alt: newData.alt ?? '',
            name: newData.name ?? '',
        };
    });
</script>

<style scoped lang="scss">
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        .image-file-modal {
            align-items: center;
            background: rgba(0, 0, 0, 0.15);
            display: none;
            height: 100vh;
            justify-content: center;
            left: 0;
            position: fixed;
            width: 100vw;
            top: 0;
            z-index: 99999;

            &.show {
                display: flex;
            }

            > .box {
                background: $seashell;
                //box-shadow: 0 0 16px 0 rgb(180, 180, 180);
                box-shadow: 0 0 16px 0 seashell;
                width: 50%;

                button {
                    margin: 10px auto;
                }

                label {
                    input {
                        margin: 5px auto;
                        width: 90%;
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
        .image-file-modal {
            > .box {
                width: 200px;
            }
        }
    }

    @include laptop-L {

    }
</style>
