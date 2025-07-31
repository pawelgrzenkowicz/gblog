import actions from './actions';
import getters from './getters';
import mutations from './mutations';
import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
import { ErrorsObject } from "@/composables/UseErrors";
import { VisibleArticle } from "@/models/article/visibleArticle";

export interface State {
    adminArticleDetails: AdminArticleDetails|null,
    adminArticlesDetails: AdminArticleDetails[]|[],
    errors: ErrorsObject|null,
    isSuccess: boolean,
    totalItems: number,
    validationError: string|null,
    visibleArticle: VisibleArticle|null,
    visibleArticles: VisibleArticle[]|[],
    imageTest: any,
    total: number,
}

export default {
    namespaced: true,
    state: <State> {
        adminArticleDetails: null,
        adminArticlesDetails: [],
        errors: null,
        isSuccess: false,
        totalItems: 0,
        validationError: null,
        visibleArticle: null,
        visibleArticles: [],
        imageTest: null,
        total: 1,
    },
    mutations,
    actions,
    getters,
}
