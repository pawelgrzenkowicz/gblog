<template>
    <main>
        <Container1024 is="article">
            <NotExist />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
    import NotExist from "@/components/NotExist.vue";

</script>

<style lang="scss" scoped>
    @include mobile-S {
        main {
            text-align: center;
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
