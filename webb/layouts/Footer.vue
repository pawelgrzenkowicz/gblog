<template>
    <footer>
        <section class="separate"></section>

        <SocialMedia />
        <Links />

        <section class="copyright">
            <p>Copyright © 2024 - Paweł Grzenkowicz - All Rights Reserved</p>
            <p>Bądź oryginalny, nie kopiuj tej strony</p>
        </section>
    </footer>
</template>

<script lang="ts" setup>
    import Links from "@/components/Footer/Links.vue";
    import SocialMedia from "@/components/Footer/SocialMedia.vue";
</script>

<style lang="scss" scoped>
    @include mobile-S {
        footer {
            background-color: $seashell;
            section {
                &.separate {
                    background-color: $brown;
                    height: 1px;
                    margin-top: 20vh;
                }
            }

            section {
                &.social-media {
                    background-color: $seashell;
                    margin: 5vh 0;
                }
            }

            section {
                &.copyright {
                    background-color: $grain_brown;
                    color: $seashell;
                    font-size: 0.6rem;
                    padding: 2vh 0;
                    text-align: center;

                    p {
                        font-family: $roxboro;
                        margin: 0;
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
