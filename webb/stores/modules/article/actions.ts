import axios from "axios";

import { AdminArticleDetailsView } from "@/models/article/adminArticleDetailsView";
import { AdminArticleDetails, type AdminArticleDetailsPOJO } from "@/models/article/adminArticleDetails";
import { Contents } from "@/models/article/contents";
import { ErrorsObject, UseErrors } from "@/composables/UseErrors";
import { Pagination } from "@/models/shared/pagination";
import { State} from "@/stores/modules/article/state";
import { VisibleArticle, type VisibleArticlePOJO } from "@/models/article/visibleArticle";
import { VisibleArticleView } from "@/models/article/visibleArticleView";

import { mainStore } from "@/stores";
import articleStore from "@/stores/modules/article"
import userStore from "@/stores/modules/user"
import { Picture } from "@/models/article/picture";
import { Ready } from "@/models/article/ready";

function getState(): State {
    return articleStore().$state
}

function getToken(): string|null {
    return userStore().$state.token;
}

function provideErrors(e: any): ErrorsObject {
    const response = e.response;
    let error: any = {'errors': {
            'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
        }};

    if (403 === response.status) {
        error = {'errors': {
                'type': [response.data['type']]
            }};
    }

    return new UseErrors().errors(error)
}

function provideValidationErrors(t: any, e: any): void {
    const response = e.response;
    if (response.data['type']) {
        t.setValidationError(response.data['type'])
    } else {
        let error = {'errors': {
                'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
            }};

        t.setErrors(new UseErrors().errors(error));
    }
}

export default {
    async addPicture(data: any) {
        this.setValidationError(null)
        this.setErrors(null)

        try {
            const response = await axios.post(`${mainStore().hosts.apiHost}/api/pictures`, data, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            return response.headers['location'];
        } catch (e: any) {
            provideValidationErrors(this, e)
        }
    },

    async createArticle(data: any) {
        try {
            this.setValidationError(null)
            this.setErrors(null)

            const response = await axios.post(`${mainStore().hosts.apiHost}/api/admin/articles`, data, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            this.setIsSuccess(true)
        } catch (e: any) {
            provideValidationErrors(this, e)
        }
    },

    async deleteArticle(uuid: string) {
        try {
            const response = await axios.delete(`${mainStore().hosts.apiHost}/api/admin/articles/${uuid}`, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            return true;
        } catch (e: any) {
            return false;
        }
    },

    async fetchAdminArticlesDetails(pagination: Pagination) {
        const query = new URLSearchParams({
            page: pagination.page.toString(),
            limit: pagination.limit.toString()
        });

        try {
            const response = await axios.get(`${mainStore().hosts.apiHost}/api/admin/articles?${query}`, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            const articles: AdminArticleDetails[] = [];
            response.data.items.forEach((article: AdminArticleDetailsView) => {
                articles.push(new AdminArticleDetails(
                    article.uuid,
                    // article.contents,
                    new Contents(article.contents['he'], article.contents['she']),
                    article.createDate,
                    new Picture(article.mainPicture['source'], article.mainPicture['alt'], article.mainPicture['extension']),
                    // article.mainPicture,
                    article.slug,
                    article.title,
                    article.categories,
                    article.publicationDate,
                    new Ready(article.ready['he'], article.ready['she']),
                    // article.ready,
                    article.removed,
                    article.views,
                    article.mainPictureName,
                    article.publicationDateFormatted,
                ));
            })

            this.setAdminArticlesDetails(articles.map(article => article.toJSON()))
            // this.setAdminArticlesDetails(articles)
            this.setTotal(response.data.total)
        } catch (e: any) {
            this.setErrors(provideErrors(e))
        }
    },

    async fetchAdminArticleBySlug(slug: string) {
        try {
            const response = await axios.get(`${mainStore().hosts.apiHost}/api/admin/articles/${slug}`, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            const data: AdminArticleDetailsView = response.data;

            const article: AdminArticleDetails = new AdminArticleDetails(
                data.uuid,
                data.contents,
                data.createDate,
                data.mainPicture,
                data.slug,
                data.title,
                data.categories,
                data.publicationDate,
                data.ready,
                data.removed,
                data.views,
                data.mainPictureName,
                data.publicationDateFormatted,
            );

            this.setAdminArticleDetails(article)
        } catch (e: any) {
            this.setErrors(provideErrors(e))
        }
    },

    async fetchAdminArticleByUuid(uuid: string) {
        try {
            const response = await axios.get(`${mainStore().hosts.apiHost}/api/admin/articles/uuid/${uuid}`, {
                headers: {
                    "Authorization": `Bearer ${getToken()}`,
                }
            });

            const data: AdminArticleDetailsView = response.data;

            const article: AdminArticleDetails = new AdminArticleDetails(
                data.uuid,
                data.contents,
                data.createDate,
                data.mainPicture,
                data.slug,
                data.title,
                data.categories,
                data.publicationDate,
                data.ready,
                data.removed,
                data.views,
                data.mainPictureName,
                data.publicationDateFormatted,
            );

            console.log("tutaj");
            console.log(article);

            // await state.dispatch('setAdminArticleDetails', article)
            this.setAdminArticleDetails(article);
        } catch (e: any) {
            this.setErrors(provideErrors(e));
        }
    },

    async fetchVisibleArticleBySlug(slug: string) {
        try {
            const response = await axios.get(`${mainStore().hosts.apiHost}/api/articles/${slug}`);

            const data: VisibleArticleView = response.data;

            const article: VisibleArticle = new VisibleArticle(
                data.uuid,
                new Contents(data.contents['he'], data.contents['she']),
                new Picture(data.mainPicture['source'], data.mainPicture['alt'], data.mainPicture['extension']),
                // data.mainPicture,
                data.slug,
                data.title,
                data.views,
                data.categories,
                data.publicationDate,
            );

            this.setVisibleArticle(article)
        } catch (e: any) {
            this.setErrors(provideErrors(e))
        }
    },

    async fetchVisibleArticles(pagination: Pagination) {
        const query = new URLSearchParams({
            page: pagination.page.toString(),
            limit: pagination.limit.toString()
        });

        try {
            const response = await axios.get(`${mainStore().hosts.apiHost}/api/visible/articles?${query}`);

            const articles: VisibleArticle[] = [];
            response.data.items.forEach((article: VisibleArticleView) => {
                articles.push(new VisibleArticle(
                    article.uuid,
                    new Contents(article.contents['he'], article.contents['she']),
                    new Picture(article.mainPicture['source'], article.mainPicture['alt'], article.mainPicture['extension']),
                    // article.mainPicture,
                    article.slug,
                    article.title,
                    article.views,
                    article.categories,
                    article.publicationDate,
                ));
            })

            this.setVisibleArticles(articles.map(article => article.toJSON()))
            this.setTotal(response.data.total)
        } catch (e: any) {
            this.setVisibleArticles([])
        }
    },

    async updateArticle(data: any) {
        try {
            this.setValidationError(null);
            this.setErrors(null);

            const response = await axios.post(`${mainStore().hosts.apiHost}/api/admin/articles/${data.uuid}`,
                data.formData,
                {
                    headers: {
                        "Authorization": `Bearer ${getToken()}`,
                        'Content-Type': 'multipart/form-data'
                    }
                }

            );

            this.setIsSuccess(true)
        } catch (e: any) {
            const response = e.response;

            if (response.data['type']) {
                this.setValidationError(response.data['type']);
            } else {
                let error = {'errors': {
                        'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                    }};

                const errors = new UseErrors().errors(error)

                this.setErrors(errors)
            }
        }
    },

    setAdminArticleDetails(data: AdminArticleDetails|null): void {
        getState().adminArticleDetails = data;
    },

    setAdminArticlesDetails(data: AdminArticleDetailsPOJO[]|[]): void {
        getState().adminArticlesDetails = data;
    },

    setErrors(data: ErrorsObject|null): void {
        getState().errors = data;
    },

    setIsSuccess(data: boolean): void {
        getState().isSuccess = data;
    },

    setTotal(total: number): void {
        getState().total = total;
    },

    setValidationError(data: string|null): void {
        getState().validationError = data;
    },

    setVisibleArticle(article: VisibleArticle|null): void {
        getState().visibleArticle = article;
    },
    setVisibleArticles(articles: VisibleArticlePOJO[]|[]): void {
        getState().visibleArticles = articles;
    },
};
