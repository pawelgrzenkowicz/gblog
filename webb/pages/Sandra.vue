<template>
    <main>
        <article class="title">
            <h1>SANDRA</h1>
        </article>
        <Container1024 is="article">
            <SiteTextImage
                :inverse="false"
                :description="text1"
                :alt="'sandra'"
                :original-image="s1"
                :small-image="s1Small"
                :medium-image="s1Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text2"
                :alt="'sandra dominikana'"
                :original-image="s2"
                :small-image="s2Small"
                :medium-image="s2Medium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text3"
                :alt="'sandra plaża wiosna'"
                :original-image="s3"
                :small-image="s3Small"
                :medium-image="s3Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text4"
                :alt="'sandra klif gdynia'"
                :original-image="s4"
                :small-image="s4Small"
                :medium-image="s4Medium"
            />

            <SiteTextImage
                :inverse="false"
                :description="text5"
                :alt="'sandra plaza gdańsk'"
                :original-image="s5"
                :small-image="s5Small"
                :medium-image="s5Medium"
            />

            <SiteTextImage
                :inverse="true"
                :description="text6"
                :alt="'sandra ogródek gdańsk'"
                :original-image="s6"
                :small-image="s6Small"
                :medium-image="s6Medium"
            />
        </Container1024>
    </main>
</template>

<script lang="ts" setup>
    import Container1024 from "@/components/Container1024.vue";
    import SiteTextImage from "@/components/SiteTextImage.vue";

    import s1 from "@/assets/images/main/original/sandra/sandra_ogrod.jpg"
    import s1Small from "@/assets/images/main/small/sandra/sandra_ogrod.jpg"
    import s1Medium from "@/assets/images/main/medium/sandra/sandra_ogrod.jpg"

    import s2 from "@/assets/images/main/original/sandra/sandra_business_woman.jpg"
    import s2Small from "@/assets/images/main/small/sandra/sandra_business_woman.jpg"
    import s2Medium from "@/assets/images/main/medium/sandra/sandra_business_woman.jpg"

    import s3 from "@/assets/images/main/original/sandra/sandra_gdynia_klif.jpeg"
    import s3Small from "@/assets/images/main/small/sandra/sandra_gdynia_klif.jpeg"
    import s3Medium from "@/assets/images/main/medium/sandra/sandra_gdynia_klif.jpeg"

    import s4 from "@/assets/images/main/original/sandra/sandra_wiosna_plaza.jpg"
    import s4Small from "@/assets/images/main/small/sandra/sandra_wiosna_plaza.jpg"
    import s4Medium from "@/assets/images/main/medium/sandra/sandra_wiosna_plaza.jpg"

    import s5 from "@/assets/images/main/original/sandra/sandra_dominikana.jpg"
    import s5Small from "@/assets/images/main/small/sandra/sandra_dominikana.jpg"
    import s5Medium from "@/assets/images/main/medium/sandra/sandra_dominikana.jpg"

    import s6 from "@/assets/images/main/original/sandra/sandra_gdansk_plaza.jpg"
    import s6Small from "@/assets/images/main/small/sandra/sandra_gdansk_plaza.jpg"
    import s6Medium from "@/assets/images/main/medium/sandra/sandra_gdansk_plaza.jpg"



    const text1 = 'Siłaczka, ale nie sportsmenka. Ze sportem mam niewiele wspólnego. Za to moja psychika potrafi bardzo dużo dźwignąć, z czego długo nie zdawałam sobie sprawy. Jestem sama dla siebie wojowniczką, która każdego dnia toczy walkę z napotkanymi przeciwnościami losu.';
    const text2 = 'Od 2015 roku choruję na przewlekłą chorobę jelit Leśniowskiego - Crohna. Początkowo zmagania z tym paskudztwem nie były łatwe, zwłaszcza kiedy pierwszą diagnozą postawioną przez lekarzy był rak jelita grubego. Ciągłe pobyty w szpitalach, masa silnych leków, bóle brzucha, biegunki, ekstremalnie chudnięcie i popadanie w anoreksję. Tak wyglądało moje ówczesne wkroczenie w dorosłość w wieku 18 lat. To wszystko miało ogromny wpływ na moją psychikę, która nie do końca sobie wtedy z tym radziła. Miewałam stany depresyjne, odrealnione myśli, a wizja ciągłego cierpienia skutkowała tym, że chciałam bezpowrotnie je skrócić.';
    const text3 = 'Minęło trochę czasu, kiedy dotarło do mnie, że "Bóg nigdy nie daje nam więcej, niż potrafimy udźwignąć". Zaakceptowałam to, że choroba pozostanie ze mną już do końca życia i najlepszym rozwiązaniem było po prostu zakumplowanie się z wrogiem (czyt. Crohnem). Na co dzień staram się nie nakręcać, nie czytać za dużo i nie myśleć. Żyję jak normalny, zdrowy człowiek i doceniam dni, kiedy nie czuję żadnego bólu.';
    const text4 = 'Mój mąż jest natomiast fanatykiem zdrowego i holistycznego podejścia do organizmu. Denerwuje się, kiedy lekceważę i macham ręką na odpowiednie dla mnie diety, regularne przyjmowanie suplementów lub wskazówki, których chce mi udzielać, aby zaleczyć stan zapalny w jelitach. Bywam uparta i nie lubię zmian. Problem zaczyna się pojawiać w momencie, kiedy zaczyna palić mi się grunt pod nogami i sytuacja wymyka się spod kontroli, a mój stan gwałtownie się pogarsza. Wtedy dociera do mnie, że przecież mogłam temu wszystkiemu zaradzić.';
    const text5 = 'Mam kreatywną duszę, która łatwo ekscytuje się na myśl o nowych pomysłach i projektach, jednak kiedy ekscytacja mija, rezygnuję z realizacji. Kiedyś prowadziłam bloga lifestylowego, pisałam też dużo o swojej chorobie, jednak zapał bardzo szybko się skończył. Do ponownego pisania zmotywował i namówił mnie Paweł. Mam nadzieję, że tym razem będę bardziej konsekwentna w swoich działaniach.';
    const text6 = 'Z wykształcenia i pasji jestem kosmetologiem. Swoje pierwsze kroki stawiałam w jednej z większych, trójmiejskich klinik. Wtedy wydawało mi się, że to praca moich marzeń. Drogi, wysokiej klasy sprzęt, prestiż, lekarze. Dopiero z czasem uświadomiłam sobie, że najważniejsza w pracy jest atmosfera i to, jakimi ludźmi się tam otaczamy. Wszystko inne to nic nieznaczący dodatek.';
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
