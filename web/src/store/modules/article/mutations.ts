import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
import { State } from "@/store/modules/article/state";
import { VisibleArticle } from "@/models/article/visibleArticle";
import { ErrorsObject } from "@/composables/UseErrors";

export default {
    setAdminArticleDetails(state: State,  data: AdminArticleDetails|null): void {
        state.adminArticleDetails = data;
    },

    setAdminArticlesDetails(state: State,  data: AdminArticleDetails[]): void {
        state.adminArticlesDetails = data;
    },

    setErrors(state: State, data: ErrorsObject|null): void {
        state.errors = data;
    },

    setIsSuccess(state: State, data: boolean): void {
        state.isSuccess = data;
    },

    setTotal(state: State, total: number): void {
        state.total = total;
    },

    setValidationError(state: State, data: string): void {
        state.validationError = data;
    },

    setVisibleArticle(state: State, data: VisibleArticle): void {
        state.visibleArticle = data;
    },

    setVisibleArticles(state: State, data: VisibleArticle[]|[]): void {
        state.visibleArticles = data;
    },
};
