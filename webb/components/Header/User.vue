<template>
    <div class="user">
<!--            <a class="user-icon">-->
<!--                <font-awesome-icon :icon="['fas', 'user']" />-->
<!--&lt;!&ndash;i na ekranie zaloguj dopiero rejestracja - dlaczego? częsciej będziesz się logował niż rejestrował&ndash;&gt;&ndash;&gt;-->
<!--&lt;!&ndash;logowania nie robić w MVP&ndash;&gt;&ndash;&gt;-->
<!--            </a>-->
    </div>
</template>

<script lang="ts" setup>

</script>

<style lang="scss" scoped>
    @include mobile-S {
        div {
            &.user {
                align-items: center;
                background: $seashell;
                display: flex;
                width: 100%;
                    a {
                        &.user-icon {
                            background-color: deeppink;
                            color: white;
                            cursor: pointer;
                            display: block;
                            font-size: 17px;
                            height: 100%;
                            padding: 14px 16px;
                            text-decoration: none;
                            width: 100%;
                            position: relative;

                            svg {
                                position: absolute;
                                top: 50%;
                                transform: translate(0, -50%);
                            }
                        }

                        &.active {
                            cursor: pointer;
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
