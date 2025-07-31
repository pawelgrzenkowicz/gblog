<template>
    <Container1024 v-if="total > itemsPerPage" is="section" class="pagination">
        <div class="pages">
            <a v-if="isPaging()" class="page" :class="{'clickable': enableClick(1)}" @click="prev">
                <span class="number">&laquo;</span>
            </a>
            <a :class="{'actual': isFirstPage, 'clickable': enableClick(1)}" class="page" @click="move(1)">
                <span class="number">1</span>
            </a>
            <a
                v-if="isPaging()"
                v-for="page in pages()"
                class="page"
                :class="{'actual': page === actualPage, 'clickable': enableClick(page)}"
                @click="move(page)"
            >
                <span class="number">{{ page ? page : '...' }}</span>
            </a>
            <a v-if="isPaging()" :class="{'actual': isLastPage, 'clickable': enableClick(lastPage)}" class="page" @click="move(lastPage)">
                <span class="number">{{ lastPage }}</span>
            </a>
            <a v-if="isPaging()" class="page" :class="{'clickable': enableClick(lastPage)}" @click="next">
                <span class="number">&raquo;</span>
            </a>
        </div>
    </Container1024>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
    import { computed, ref, watch } from "vue";

    const emits = defineEmits([
        'update:modelValue',
    ]);
    const props = withDefaults(
        defineProps<{
            itemsPerPage: number,
            total: number,
            modelValue: number,
        }>(),
        {
            itemsPerPage: 10,
            total: 10,
            modelValue: 1,
        }
    );

    const actualPage = ref<number>(props.modelValue || 1);
    const lastPage = computed<number>(() => Math.ceil(props.total / props.itemsPerPage));
    const isFirstPage = computed<boolean>(() => actualPage.value === 1);
    const isLastPage = computed<boolean>(() => actualPage.value === lastPage.value);

    const move = (index: number): void => {
        (index <= lastPage.value) && (index >= 1) && (actualPage.value = index);
    }
    const next = () => {
        move(actualPage.value + 1);
    }
    const prev = () => {
        move(actualPage.value - 1);
    }

    function isPaging(): boolean {
        return props.total > props.itemsPerPage;
    }

    watch(actualPage, (value) => {
        emits('update:modelValue', value);
    });

    watch(() => props.modelValue, (value) => {
        actualPage.value = value;
    });

    function enableClick(page: any): boolean {
        return !isNaN(page) && page !== actualPage.value;
    }

    function pages(): any[] {
        let pages = [];


        const _actualPage = actualPage.value;
        const _lastPage = lastPage.value;
        const maxElements = 9;

        if (_lastPage <= maxElements) {
            for (let i = 2; i <= maxElements; i++) {
                if (i > 1 && i < _lastPage) {
                    pages.push(i);
                }

            }

            return pages;
        }

        for (let i = _actualPage - 2; i <= _actualPage + 2; i++) {
            if (i > 1 && i < _lastPage) {
                pages.push(i);
            }
        }

        if (_actualPage >= 5) {
            pages.unshift(null);
        }

        if (_lastPage - 3 > _actualPage) {
            pages.push(null);
        }

        return pages;
    }

</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    section {
        &.pagination {
            div {
                &.pages {
                    background-color: $seashell;
                    text-align: center;
                    a {
                        &.page {
                            background-color: $grain_brown;
                            border-radius: 50%;
                            color: black;
                            display: inline-block;
                            height: 30px;
                            margin: 0 5px;
                            padding: 1.5rem;
                            position: relative;
                            text-align: center;
                            width: 30px;

                            span {
                                &.number {
                                    font-weight: bold;
                                    left: 50%;
                                    position: absolute;
                                    top: 50%;
                                    transform: translate(-50%,-50%);
                                }
                            }
                        }
                        &.clickable {
                            cursor: pointer;
                        }
                        &.actual {
                            color: white;
                        }
                    }
                }
            }
        }
    }

    @include mobile-S {

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
