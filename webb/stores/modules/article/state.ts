import { AdminArticleDetails, type AdminArticleDetailsPOJO } from "@/models/article/adminArticleDetails";
import { ErrorsObject } from "@/composables/UseErrors";
import { VisibleArticle, type VisibleArticlePOJO } from "@/models/article/visibleArticle";

export interface State {
    adminArticleDetails: AdminArticleDetails|null,
    adminArticlesDetails: AdminArticleDetailsPOJO[]|[],
    errors: ErrorsObject|null,
    isSuccess: boolean,
    totalItems: number,
    validationError: string|null,
    visibleArticle: VisibleArticle|null,
    visibleArticles: VisibleArticlePOJO[]|[],
    imageTest: any,
    total: number,
}

const state: State = {
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
};

export default state;
