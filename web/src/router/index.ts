import { createRouter, createWebHistory } from "vue-router";
import AboutUs from "@/pages/AboutUs.vue";
import Admin from "@/pages/Admin/Admin.vue";
import AdminArticle from "@/pages/Admin/AdminArticle.vue";
import AdminUpdateArticle from "@/pages/Admin/AdminUpdateArticle.vue";
import Article from "@/pages/Article.vue";
import ArticleList from "@/pages/ArticleList.vue";
import CreateArticle from "@/pages/Admin/CreateArticle.vue";
import Index from "@/pages/Index.vue";
import Login from "@/pages/Login.vue";
import Partnership from "@/pages/Partnership.vue";
import Pawel from "@/pages/Pawel.vue";
import PrivacyPolicy from "@/pages/PrivacyPolicy.vue";
import Sandra from "@/pages/Sandra.vue";
import NotFound from "@/pages/NotFound.vue";
import { UseUserAccessGuard } from "@/composables/UseUserAccessGuard";

export default createRouter({
    history: createWebHistory(),
    routes: [
        {
            component: Index,
            name: '_index',
            path: '/',
        },
        {
            component: AboutUs,
            name: '_about_us',
            path: '/o-nas',
        },
        {
            component: Admin,
            name: '_admin',
            path: '/adminsp',
            beforeEnter: (to, from, next) => {
                const { isAdmin } = UseUserAccessGuard();

                if(!isAdmin.value) {
                    console.log('brak dostępu');
                    next({ name: '_login' });
                } else {
                    next();
                }
            },
        },
        {
            component: AdminArticle,
            name: '_admin_blog_article',
            path: '/adminsp/blog/:slug',
            props: true,
            beforeEnter: (to, from, next) => {
                const { isAdmin } = UseUserAccessGuard();

                if(!isAdmin.value) {
                    console.log('brak dostępu');
                    next({ name: '_login' });
                } else {
                    next();
                }
            },
        },
        {
            component: AdminUpdateArticle,
            name: '_admin_blog_update_article',
            path: '/adminsp/update/blog/:uuid',
            props: true,
            beforeEnter: (to, from, next) => {
                const { isAdmin } = UseUserAccessGuard();

                if(!isAdmin.value) {
                    console.log('brak dostępu');
                    next({ name: '_login' });
                } else {
                    next();
                }
            },
        },
        {
            component: CreateArticle,
            name: '_create_article',
            path: '/adminsp/create/article',
            beforeEnter: (to, from, next) => {
                const { isAdmin } = UseUserAccessGuard();

                if(!isAdmin.value) {
                    console.log('brak dostępu');
                    next({ name: '_login' });
                } else {
                    next();
                }
            },
        },
        {
            component: ArticleList,
            name: '_blog',
            path: '/blog',
        },
        {
            component: Article,
            name: '_blog_article',
            path: '/blog/:slug',
            props: true,
        },
        {
            component: Login,
            name: '_login',
            path: '/logowanie',
        },
        {
            component: Partnership,
            name: '_partnership',
            path: '/wspolpraca',
        },
        {
            component: Pawel,
            name: '_pawel',
            path: '/pawel',
        },
        {
            component: PrivacyPolicy,
            name: '_privacy_policy',
            path: '/polityka-prywatnosci',
        },
        // {
        //     component: Registration,
        //     name: '_registration',
        //     path: '/rejestracja',
        // },
        {
            component: Sandra,
            name: '_sandra',
            path: '/sandra',
        },
        // {
        //     component: Tips,
        //     name: '_tips',
        //     path: '/wskazowki',
        // },
        { path: '/:notFound(.*)', component: NotFound },

    ],
    scrollBehavior(to, from, savedPosition) {
        // Zwraca pozycję do której przeglądarka powinna przewinąć
        // Jeśli zapisana pozycja istnieje (np. po wciśnięciu "wstecz" w przeglądarce)
        if (savedPosition) {
            return savedPosition;
        } else {
            // W przeciwnym razie przewija do góry
            return { top: 0 };
        }
    }
});
