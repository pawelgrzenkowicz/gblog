import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
import { State } from "@/store/modules/article/state";
import { VisibleArticle } from "@/models/article/visibleArticle";
import { ErrorsObject } from "@/composables/UseErrors";

export default {

    getAdminArticleDetails(state: State): AdminArticleDetails|null {
        return state.adminArticleDetails;
    },

    getAdminArticlesDetails(state: State): AdminArticleDetails[]|[] {
        return state.adminArticlesDetails;
    },

    getErrors(state: State): ErrorsObject|null {
        return state.errors;
    },

    getIsSuccess(state: State): boolean {
        return state.isSuccess;
    },

    getTotal(state: State): number {
        return state.total;
    },

    getValidationError(state: State): string|null {
        return state.validationError;
    },

    getVisibleArticle(state: State): VisibleArticle|null {
        return state.visibleArticle;
    },

    getVisibleArticles(state: State): VisibleArticle[]|[] {
        // return [];
        return state.visibleArticles;
    },
};
