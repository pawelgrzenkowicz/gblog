<template>
    <section class="social-media">
        <article>
            <FacebookLink
                :link="facebook_link"
                text=""
                class="media-item"
                :style="'color-gb'"
            >
            </FacebookLink>
            <InstagramLink
                :link="instagram_link"
                text=""
                class="media-item"
                :style="'color-gb'"
            >
            </InstagramLink>
            <YouTubeLink
                :link="youtube_link"
                text=""
                class="media-item"
                :style="'color-gb'"
            >
            </YouTubeLink>
            <TikTokLink
                :link="tiktok_link"
                text=""
                class="media-item"
                :style="'color-gb'"
            >
            </TikTokLink>
        </article>
    </section>
</template>

<script lang="ts" setup>
    import InstagramLink from "@/components/Footer/InstagramLink.vue";
    import FacebookLink from "@/components/Footer/FacebookLink.vue";
    import YouTubeLink from "@/components/Footer/YouTubeLink.vue";
    import TikTokLink from "@/components/Footer/TikTokLink.vue";

    import { facebook_link, instagram_link, youtube_link, tiktok_link } from "../../../config/parameters";

</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    section {
        text-align: center;

        article {
            div {
                &.media-item {
                    display: inline-block;
                    font-size: 3rem;
                    margin: 0 10px;
                    padding: 5px;
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
