<template>
    <main>
        <article class="title">
            <h1>PAWEŁ</h1>
        </article>
        <Container1024 is="article">
            <SiteTextImage
                :inverse="false"
                :description="text1"
                :alt="'rugby'"
                :original-image="pawelRugby"
                :small-image="pawelRugbySmall"
                :medium-image="pawelRugbyMedium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text2"
                :alt="'gdynia restauracja'"
                :original-image="pawelRestauracja"
                :small-image="pawelRestauracjaSmall"
                :medium-image="pawelRestauracjaMedium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text3"
                :alt="'gdynia klif morze'"
                :original-image="pawelGdyniaKlif"
                :small-image="pawelGdyniaKlifSmall"
                :medium-image="pawelGdyniaKlifMedium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text4"
                :alt="'dominikana wakacje'"
                :original-image="pawelMelex"
                :small-image="pawelMelexSmall"
                :medium-image="pawelMelexMedium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text5"
                :alt="'basen wakacje las'"
                :original-image="pawelBasen"
                :small-image="pawelBasenSmall"
                :medium-image="pawelBasenMedium"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import SiteTextImage from "@/components/SiteTextImage.vue";
    import Container1024 from "@/components/Container1024.vue";

    import pawelRugby from '@/assets/images/main/original/pawel/pawel_rugby.jpeg';
    import pawelRugbySmall from '@/assets/images/main/small/pawel/pawel_rugby.jpeg';
    import pawelRugbyMedium from '@/assets/images/main/medium/pawel/pawel_rugby.jpeg';

    import pawelRestauracja from '@/assets/images/main/original/pawel/pawel_restauracja.jpeg';
    import pawelRestauracjaSmall from '@/assets/images/main/small/pawel/pawel_restauracja.jpeg';
    import pawelRestauracjaMedium from '@/assets/images/main/medium/pawel/pawel_restauracja.jpeg';

    import pawelGdyniaKlif from '@/assets/images/main/original/pawel/pawel_gdynia_klif.jpeg';
    import pawelGdyniaKlifSmall from '@/assets/images/main/small/pawel/pawel_gdynia_klif.jpeg';
    import pawelGdyniaKlifMedium from '@/assets/images/main/medium/pawel/pawel_gdynia_klif.jpeg';

    import pawelMelex from '@/assets/images/main/original/pawel/pawel_melex.jpeg';
    import pawelMelexSmall from '@/assets/images/main/small/pawel/pawel_melex.jpeg';
    import pawelMelexMedium from '@/assets/images/main/medium/pawel/pawel_melex.jpeg';

    import pawelBasen from '@/assets/images/main/original/pawel/pawel_basen.jpeg';
    import pawelBasenSmall from '@/assets/images/main/small/pawel/pawel_basen.jpeg';
    import pawelBasenMedium from '@/assets/images/main/medium/pawel/pawel_basen.jpeg';

    const text1 = 'Sportowiec. Związany z rugby przez 17 lat. Aktualnie nie trenuję zawodowo. Korzystając z wiedzy zdobytej przez wszystkie lata nadal ćwiczę na siłowni, biegam, trzymam dietę, staram się zdrowo odżywiać i saunuje.';
    const text2 = 'Zawodowo programista. Nie nerd. Chociaż siedzieć ponad dobę przy komputerze to dla mnie żadne wyzwanie. Pracoholik lubiący swoją pracę jak wszystko działa i nienawidzący jak wszystko świeci się na czerwono.';
    const text3 = 'Wiecznie zamyślony, poszukujący balansu pomiędzy pracą, treningami, regeneracją, nauką i spędzaniem czasu z rodziną. Przez to zabiegany, wykorzystujący każdą sekundę życia na 100%.';
    const text4 = 'Maniak gier komputerowych, traktujący życie jak grę w którym rozwijam się w każdym możliwym aspekcie. Konsekwentnie. Cierpliwie. Uparcie dążąc do postawionych celów.';
    const text5 = 'Podobno wredny, skąpy, uparty i marudny. </br> Ja uważam, że jestem po prostu bezpośredni, dobrze zarządzam pieniędzmi, ekonomiczny w stylu życia; bycie upartym uważam za zaletę przy odpowiedniej ilości elastyczności, wymagający nie marudny.';
</script>

<style lang="scss" scoped>
    @import '@/assets/shared/breakpoints';

    @include mobile-S {
        article {
            &.title {
                background-color: $grain_brown;
                padding: 5vh 0;
                margin-bottom: 5vh;
                text-align: center;

                h1 {
                    color: $seashell;
                    padding: 0;
                    margin: 0;
                }
            }

            &.container {
                background-color: $grain_brown;
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
