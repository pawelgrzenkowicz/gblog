import type { RouterConfig } from '@nuxt/schema'
import AboutUs from "@/pages/AboutUs.vue";
import Admin from "@/pages/Admin/Admin.vue";
import AdminArticle from "@/pages/Admin/AdminArticle.vue";
import AdminUpdateArticle from "@/pages/Admin/AdminUpdateArticle.vue";
import Article from "@/pages/Article.vue";
import ArticleList from "@/pages/ArticleList.vue";
import CreateArticle from "@/pages/Admin/CreateArticle.vue";
import Index from "@/pages/Index.vue";
import Login from "@/pages/Login.vue";
import NotFound from "@/pages/NotFound.vue";
import Partnership from "@/pages/Partnership.vue";
import Pawel from "@/pages/Pawel.vue";
import PrivacyPolicy from "@/pages/PrivacyPolicy.vue";
import Sandra from "@/pages/Sandra.vue";
import { UseUserAccessGuard } from "@/composables/UseUserAccessGuard";
import storeUser from "@/stores/modules/user";

export default <RouterConfig>{
    routes: (_routes) => [
        {
            name: 'index',
            path: '/',
            component: Index,
        },
        {
            name: 'about-us',
            path: '/o-nas',
            component: AboutUs,
        },
        {
            name: 'about-us',
            path: '/o-nas',
            component: AboutUs,
        },
        {
            component: ArticleList,
            name: 'blog',
            path: '/blog',
        },
        {
            component: Article,
            name: 'blog-article',
            path: '/blog/:slug',
            props: true,
        },
        {
            component: Login,
            name: 'login',
            path: '/logowanie',
        },
        {
            component: Partnership,
            name: 'partnership',
            path: '/wspolpraca',
        },
        {
            component: Pawel,
            name: 'pawel',
            path: '/pawel',
        },
        {
            component: PrivacyPolicy,
            name: 'privacy-policy',
            path: '/polityka-prywatnosci',
        },
        // {
        //     component: Registration,
        //     name: 'registration',
        //     path: '/rejestracja',
        // },
        {
            component: Sandra,
            name: 'sandra',
            path: '/sandra',
        },
        // {
        //     component: Tips,
        //     name: 'tips',
        //     path: '/wskazowki',
        // },
        {
            component: Admin,
            name: 'admin',
            path: '/adminsp',
            beforeEnter: (to, from, next) => {
                checkAdminAccess(next);
            }
            // beforeEnter: (to, from, next) => {
            //     const { isAdmin } = UseUserAccessGuard();
            //
            //     if(!isAdmin.value) {
            //         console.log('brak dostępu');
            //         next({ name: 'login' });
            //     } else {
            //         next();
            //     }
            // },
        },
        {
            component: AdminArticle,
            name: 'admin-blog-article',
            path: '/adminsp/blog/:slug',
            props: true,
            beforeEnter: (to, from, next) => {
                checkAdminAccess(next);
            }
        },
        {
            component: AdminUpdateArticle,
            name: 'admin-blog-update-article',
            path: '/adminsp/update/blog/:uuid',
            props: true,
            beforeEnter: (to, from, next) => {
                checkAdminAccess(next);
            }
        },
        {
            component: CreateArticle,
            name: 'create-article',
            path: '/adminsp/create/article',
            beforeEnter: (to, from, next) => {
                checkAdminAccess(next);
            }
        },
        { path: '/:notFound(.*)', component: NotFound },
    ],
    beforeEach: async (to: any, from: any) => {
        if (to.path.startsWith('/adminsp')) {

            const userStore = storeUser()

        }

        // Zwróć true, aby kontynuować nawigację
        return true;
    }
} satisfies RouterConfig

function checkAdminAccess(next: Function) {
    const { isAdmin } = UseUserAccessGuard();

    if (!isAdmin) {
        console.log('Brak dostępu');
        next({ name: 'login' });
    } else {
        next();
    }
}
