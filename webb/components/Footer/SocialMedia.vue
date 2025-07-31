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
    import { useRuntimeConfig } from "nuxt/app";

    import InstagramLink from "@/components/Footer/InstagramLink.vue";
    import FacebookLink from "@/components/Footer/FacebookLink.vue";
    import YouTubeLink from "@/components/Footer/YouTubeLink.vue";
    import TikTokLink from "@/components/Footer/TikTokLink.vue";

    const facebook_link = useRuntimeConfig().public.FACEBOOK_LINK;
    const instagram_link = useRuntimeConfig().public.INSTAGRAM_LINK;
    const youtube_link = useRuntimeConfig().public.YOUTUBE_LINK;
    const tiktok_link = useRuntimeConfig().public.TIKTOK_LINK;

</script>

<style lang="scss" scoped>


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
