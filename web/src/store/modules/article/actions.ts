import axios from "axios";

import { AdminArticleDetailsView } from "@/models/article/adminArticleDetailsView";
import { AdminArticleDetails } from "@/models/article/adminArticleDetails";
import { ActionContext } from "vuex";
import { Contents } from "@/models/article/contents";
import { ErrorsObject, UseErrors } from "@/composables/UseErrors";
import { Pagination } from "@/models/shared/pagination";
import { RootState } from "@/store";
import { State } from "@/store/modules/article/state";
import { VisibleArticle } from "@/models/article/visibleArticle";
import { VisibleArticleView } from "@/models/article/visibleArticleView";

export default {
    async addPicture(context: ActionContext<State, RootState>, data: any) {

        await context.dispatch('setValidationError', null);
        await context.dispatch('setErrors', null);

        try {
            const response = await axios.post(`${context.rootState.apiHost}/api/pictures`, data, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
                }
            });

            return response.headers['location'];
        } catch (e: any) {
            const response = e.response;

            if (response.data['type']) {
                await context.dispatch('setValidationError', response.data['type']);
            } else {
                let error = {'errors': {
                        'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                    }};

                const errors = new UseErrors().errors(error)

                await context.dispatch('setErrors', errors);
            }
        }
    },

    async createArticle(context: ActionContext<State, RootState>, data: any) {
        try {
            await context.dispatch('setValidationError', null);
            await context.dispatch('setErrors', null);

            const response = await axios.post(`${context.rootState.apiHost}/api/admin/articles`, data, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
                }
            });

            await context.dispatch('setIsSuccess', true)
        } catch (e: any) {
            const response = e.response;


            if (response.data['type']) {
                await context.dispatch('setValidationError', response.data['type']);
            } else {
                let error = {'errors': {
                        'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                    }};

                const errors = new UseErrors().errors(error)

                await context.dispatch('setErrors', errors);
            }
        }
    },

    async deleteArticle(context: ActionContext<State, RootState>, uuid: string) {
        try {
            const response = await axios.delete(`${context.rootState.apiHost}/api/admin/articles/${uuid}`, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
                }
            });

            return true;
        } catch (e: any) {
            return false;
        }
    },

    async getAdminArticlesDetails(context: ActionContext<State, RootState>, pagination: Pagination) {
        const query = new URLSearchParams({
            page: pagination.page.toString(),
            limit: pagination.limit.toString()
        });

        try {
            const response = await axios.get(`${context.rootState.apiHost}/api/admin/articles?${query}`, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
                }
            });

            const articles: AdminArticleDetails[] = [];
            response.data.items.forEach((article: AdminArticleDetailsView) => {
                articles.push(new AdminArticleDetails(
                    article.uuid,
                    article.contents,
                    article.createDate,
                    article.mainPicture,
                    article.slug,
                    article.title,
                    article.categories,
                    article.publicationDate,
                    article.ready,
                    article.removed,
                    article.views,
                    article.mainPictureName,
                    article.publicationDateFormatted,
                ));
            })

            await context.dispatch('setAdminArticlesDetails', articles)
            await context.dispatch('setTotal', response.data.total)

        } catch (e: any) {
            const response = e.response;
            let error: any = {'errors': {
                    'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                }};

            if (403 === response.status) {
                error = {'errors': {
                    'type': [response.data['type']]
                }};
            }

            const errors = new UseErrors().errors(error)

            await context.dispatch('setErrors', errors);
        }
    },

    async getAdminArticleBySlug(context: ActionContext<State, RootState>, slug: string) {
        try {
            const response = await axios.get(`${context.rootState.apiHost}/api/admin/articles/${slug}`, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
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

            await context.dispatch('setAdminArticleDetails', article)
        } catch (e: any) {
            const response = e.response;
            let error: any = {'errors': {
                    'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                }};

            if (403 === response.status) {
                error = {'errors': {
                        'type': [response.data['type']]
                    }};
            }

            const errors = new UseErrors().errors(error)

            await context.dispatch('setErrors', errors);
        }
    },

    async getAdminArticleByUuid(context: ActionContext<State, RootState>, uuid: string) {
        try {
            const response = await axios.get(`${context.rootState.apiHost}/api/admin/articles/uuid/${uuid}`, {
                headers: {
                    "Authorization": `Bearer ${context.rootState.user.token}`,
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

            await context.dispatch('setAdminArticleDetails', article)
        } catch (e: any) {
            const response = e.response;
            let error: any = {'errors': {
                    'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                }};

            if (403 === response.status) {
                error = {'errors': {
                        'type': [response.data['type']]
                    }};
            }

            const errors = new UseErrors().errors(error)

            await context.dispatch('setErrors', errors);
        }
    },

    async getVisibleArticleBySlug(context: ActionContext<State, RootState>, slug: string) {
        try {
            const response = await axios.get(`${context.rootState.apiHost}/api/articles/${slug}`);

            const data: VisibleArticleView = response.data;

            const article: VisibleArticle = new VisibleArticle(
                data.uuid,
                new Contents(data.contents['he'], data.contents['she']),
                data.mainPicture,
                data.slug,
                data.title,
                data.views,
                data.categories,
                data.publicationDate,
            );

            await context.dispatch('setVisibleArticle', article)
        } catch (e: any) {
            const response = e.response;
            let error: any = {'errors': {
                    'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                }};

            if (403 === response.status) {
                error = {'errors': {
                        'type': [response.data['type']]
                    }};
            }

            const errors = new UseErrors().errors(error)

            await context.dispatch('setErrors', errors);
        }
    },

    async getVisibleArticles(context: ActionContext<State, RootState>, pagination: Pagination) {
        const query = new URLSearchParams({
            page: pagination.page.toString(),
            limit: pagination.limit.toString()
        });

        try {
            const response = await axios.get(`${context.rootState.apiHost}/api/visible/articles?${query}`);

            const articles: VisibleArticle[] = [];
            response.data.items.forEach((article: VisibleArticleView) => {
                articles.push(new VisibleArticle(
                    article.uuid,
                    new Contents(article.contents['he'], article.contents['she']),
                    article.mainPicture,
                    article.slug,
                    article.title,
                    article.views,
                    article.categories,
                    article.publicationDate,
                ));
            })

            await context.dispatch('setVisibleArticles', articles)
            await context.dispatch('setTotal', response.data.total)
        } catch (e: any) {
            await context.dispatch('setVisibleArticles', [])
        }
    },

    async updateArticle(context: ActionContext<State, RootState>, data: any) {
        try {
            await context.dispatch('setValidationError', null);
            await context.dispatch('setErrors', null);

            const response = await axios.post(`${context.rootState.apiHost}/api/admin/articles/${data.uuid}`,
                data.formData,
                {
                    headers: {
                        "Authorization": `Bearer ${context.rootState.user.token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                }

            );

            await context.dispatch('setIsSuccess', true)
        } catch (e: any) {
            const response = e.response;

            if (response.data['type']) {
                await context.dispatch('setValidationError', response.data['type']);
            } else {
                let error = {'errors': {
                        'SOMETHING_WENT_WRONG': ['PLEASE_CONTACT_WITH_ADMIN']
                    }};

                const errors = new UseErrors().errors(error)

                await context.dispatch('setErrors', errors);
            }
        }
    },

    setAdminArticleDetails(context: ActionContext<State, RootState>, data: AdminArticleDetails|null): void {
        context.commit('setAdminArticleDetails', data)
    },

    setAdminArticlesDetails(context: ActionContext<State, RootState>, data: AdminArticleDetails[]): void {
        context.commit('setAdminArticlesDetails', data)
    },

    setErrors(context: ActionContext<State, RootState>, data: ErrorsObject|null): void {
        context.commit('setErrors', data);
    },

    setIsSuccess(context: ActionContext<State, RootState>, data: boolean): void {
        context.commit('setIsSuccess', data);
    },

    setTotal(context: ActionContext<State, RootState>, total: number): void {
        context.commit('setTotal', total)
    },

    setValidationError(context: ActionContext<State, RootState>, data: string): void {
        context.commit('setValidationError', data);
    },

    setVisibleArticle(context: ActionContext<State, RootState>, data: VisibleArticle): void {
        context.commit('setVisibleArticle', data)
    },

    setVisibleArticles(context: ActionContext<State, RootState>, data: VisibleArticle[]|[]): void {
        context.commit('setVisibleArticles', data)
    },
};
