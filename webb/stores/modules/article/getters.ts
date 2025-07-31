import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
import { State } from "@/stores/modules/article/state";
import { VisibleArticle, type VisibleArticlePOJO } from "@/models/article/visibleArticle";
import { ErrorsObject } from "@/composables/UseErrors";

import articleStore from "@/stores/modules/article"

function getState(): State {
    return articleStore().$state
}

export default {
    getAdminArticleDetails(): AdminArticleDetails|null {
        return getState().adminArticleDetails;
    },

    getAdminArticlesDetails(): AdminArticleDetails[]|[] {
        return getState().adminArticlesDetails;
    },

    getErrors(): ErrorsObject|null {
        return getState().errors;
    },

    getIsSuccess(): boolean {
        return getState().isSuccess;
    },

    getTotal(): number {
        return getState().total;
    },

    getValidationError(): string|null {
        return getState().validationError;
    },

    getVisibleArticle(): VisibleArticle|null {
        return getState().visibleArticle;
    },

    getVisibleArticles(): VisibleArticlePOJO[]|[] {
        return getState().visibleArticles;
    },
};
