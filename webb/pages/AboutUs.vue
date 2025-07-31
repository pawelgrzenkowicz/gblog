<template>
    <main>
        <article class="title">
            <h1>O NAS</h1>
        </article>
        <Container1024 is="article">
            <SiteTextImage
                :inverse="false"
                :description="text1"
                :alt="'gdynia klif'"
                :original-image="m1"
                :small-image="m1Small"
                :medium-image="m1Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text2"
                :alt="'sesja poślubna gdańsk jacht'"
                :original-image="m2"
                :small-image="m2Small"
                :medium-image="m2Medium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text3"
                :alt="'horyzont'"
                :original-image="m3"
                :small-image="m3Small"
                :medium-image="m3Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text4"
                :alt="'sesja brzuszkowa'"
                :original-image="m4"
                :small-image="m4Small"
                :medium-image="m4Medium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text5"
                :alt="'sesja narzeczeńska'"
                :original-image="m5"
                :small-image="m5Small"
                :medium-image="m5Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text6"
                :alt="'sesja poślubna'"
                :original-image="m6"
                :small-image="m6Small"
                :medium-image="m6Medium"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
    import SiteTextImage from "@/components/SiteTextImage.vue";

    import m1 from "@/assets/images/main/original/my/my_gdynia_klif_m.jpg";
    import m1Small from "@/assets/images/main/small/my/my_gdynia_klif_m.jpg";
    import m1Medium from "@/assets/images/main/medium/my/my_gdynia_klif_m.jpg";
    
    import m2 from "@/assets/images/main/original/my/sesja_po_slubna_statek.jpg";
    import m2Small from "@/assets/images/main/small/my/sesja_po_slubna_statek.jpg";
    import m2Medium from "@/assets/images/main/medium/my/sesja_po_slubna_statek.jpg";
    
    import m3 from "@/assets/images/main/original/my/nasz_horyzont_m.jpg";
    import m3Small from "@/assets/images/main/small/my/nasz_horyzont_m.jpg";
    import m3Medium from "@/assets/images/main/medium/my/nasz_horyzont_m.jpg";
    
    import m4 from "@/assets/images/main/original/my/sesja_brzuszkowa_morze_m.jpg";
    import m4Small from "@/assets/images/main/small/my/sesja_brzuszkowa_morze_m.jpg";
    import m4Medium from "@/assets/images/main/medium/my/sesja_brzuszkowa_morze_m.jpg";
    
    import m5 from "@/assets/images/main/original/my/sesja_narzeczenska_m.jpg";
    import m5Small from "@/assets/images/main/small/my/sesja_narzeczenska_m.jpg";
    import m5Medium from "@/assets/images/main/medium/my/sesja_narzeczenska_m.jpg";
    
    import m6 from "@/assets/images/main/original/my/sesja_po_slubna_m.jpg";
    import m6Small from "@/assets/images/main/small/my/sesja_po_slubna_m.jpg";
    import m6Medium from "@/assets/images/main/medium/my/sesja_po_slubna_m.jpg";

    const text1 = 'Jak sama nazwa wskazuje - zmaczowaliśmy się na sławnym portalu randkowym w 2019 roku. Od tamtej pory tworzymy całkiem zgrany duet, chociaż bardzo często się ze sobą nie zgadzamy i różnimy w swoich poglądach.';
    const text2 = 'Pomysł na bloga powstał z żartu. Pracowałem z przyjacielem nad pewnym projektem i podczas luźnej rozmowy rzuciłem “jedyne co mnie łączy z Sandrą to nazwisko”. Od razu w głowie pojawił się pomysł na bloga, w którym będziemy opowiadać o tym samym z różnej perspektywy.';
    const text3 = 'Jesteśmy całkowicie odmienni, pełni kontrastów, a mimo wszystko pasujemy do siebie idealnie. Uzupełniamy się wzajemnie jak puzzle - stąd też pomysł na logo.';
    const text4 = 'Oszczędny - rozrzutna</br>Ułożony - roztrzepana</br>Obojętny - empatyczna</br>Zawzięty - ustepliwa</br>Punktualny - wiecznie spóźniona</br>To tylko garstka naszych różnic';
    const text5 = 'Mamy zwykłe, choć ciekawe życie, którym chcemy się podzielić. Nie tylko tą słodką i różową częścią. Chcemy pokazać, jak wygląda życie we dwójkę bez nadmiernego lukru i owijania w bawełnę. Z wielkim bagażem doświadczeń, który udało nam się wspólnie dźwigać.';
    const text6 = 'Lubimy być autentyczni i szczerzy. Ci, co nas znają, wiedzą że w naszym związku bywa burzliwie, ale po każdej awanturze wychodzi słońce. Zawsze stajemy za sobą murem i wiemy, że nie ma dla nas rzeczy niemożliwych do przeskoczenia.';
</script>

<style lang="scss" scoped>
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
