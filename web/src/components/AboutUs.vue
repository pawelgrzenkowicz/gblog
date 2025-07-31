<template>
    <section class="about-us">
        <div class="logo">
            <RouterLink :to="{ name: '_about_us' }">
                <ImageRender
                    :alt="'o nas'"
                    :medium-image="aboutUsMedium"
                    :original-image="aboutUs"
                    :small-image="aboutUsSmall"
                />
                <div class="text-background">
                    <h5>
                        O NAS
                    </h5>
                </div>
            </RouterLink>
        </div>

        <div class="logo">
            <RouterLink :to="{ name: '_sandra' }">
                <ImageRender
                    :alt="'Sandra'"
                    :medium-image="sandraMedium"
                    :original-image="sandra"
                    :small-image="sandraSmall"
                />
                <div class="text-background">
                    <h5>
                        SANDRA
                    </h5>
                </div>
            </RouterLink>
        </div>

        <div class="logo">
            <RouterLink :to="{ name: '_pawel' }">
                <ImageRender
                    :alt="'Paweł'"
                    :medium-image="pawelMedium"
                    :original-image="pawel"
                    :small-image="pawelSmall"
                />
                <div class="text-background">
                    <h5>
                        PAWEŁ
                    </h5>
                </div>
            </RouterLink>
        </div>

        <div class="logo">
            <RouterLink :to="{ name: '_partnership' }">
                <ImageRender
                    :alt="'współpraca'"
                    :medium-image="partnershipMedium"
                    :original-image="partnership"
                    :small-image="partnershipSmall"
                />
                <div class="text-background">
                    <h5>
                        WSPÓŁPRACA
                    </h5>
                </div>
            </RouterLink>
        </div>

    </section>
</template>

<script lang="ts" setup>
    import aboutUs from "@/assets/images/main/original/my/my_plaza.jpg";
    import aboutUsSmall from "@/assets/images/main/small/my/my_plaza.jpg";
    import aboutUsMedium from "@/assets/images/main/medium/my/my_plaza.jpg";

    import sandra from "@/assets/images/main/original/sandra/sandra_klif.jpeg";
    import sandraSmall from "@/assets/images/main/small/sandra/sandra_klif_morze.jpeg";
    import sandraMedium from "@/assets/images/main/medium/sandra/sandra_klif_morze.jpeg";

    import pawel from "@/assets/images/main/original/pawel/pawel_klif_morze.jpg";
    import pawelSmall from "@/assets/images/main/small/pawel/pawel_klif.jpg";
    import pawelMedium from "@/assets/images/main/medium/pawel/pawel_klif.jpg";

    import partnership from "@/assets/images/main/original/my/brzuszek_para.jpg";
    import partnershipSmall from "@/assets/images/main/small/my/brzuszek_para.jpg";
    import partnershipMedium from "@/assets/images/main/medium/my/brzuszek_para.jpg";
    import ImageRender from "@/components/ImageRender.vue";
</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        section {
            &.about-us {
                align-items: center;
                background-color: $seashell;
                justify-content: center;
                margin-bottom: 100px;

                .logo {
                    //display: inline-block;
                    height: 150px;
                    margin: 30px auto;
                    position: relative;
                    //width: 150px;
                    width: 100%;


                    a {
                        color: inherit;
                        text-decoration: none;
                    }

                    picture {
                        img {
                            height: 100%;
                            object-fit: cover;
                            width: 100%;
                        }
                    }

                    img {
                        height: 100%;
                        object-fit: cover;
                        width: 100%;
                    }

                    .text-background {
                        align-items: center;
                        display: flex;
                        justify-content: center;
                        height: 100%;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        h5 {
                            background: rgba(255, 255, 255, 0.5);
                            font-family: $roxboro;
                            padding: 20px 30vw;
                            white-space: nowrap;
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
        section {
            &.about-us {
                align-items: center;
                display: flex;
                height: 300px;
                justify-content: center;

                .logo {
                    display: inline-block;
                    height: 250px;
                    margin: 10px;
                    position: relative;
                    width: 250px;

                    a {
                        color: inherit;
                        text-decoration: none;
                    }

                    img {
                        min-height: 100%;
                        object-fit: cover;
                        width: 100%;
                    }
                    .text-background {
                        align-items: center;
                        display: flex;
                        justify-content: center;
                        height: 100%;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        h5 {
                            background: rgba(255, 255, 255, 0.5);
                            padding: 20px 50px;
                        }
                    }
                }
            }
        }
    }

    @include laptop {

    }

    @include laptop-L {

    }
</style>
