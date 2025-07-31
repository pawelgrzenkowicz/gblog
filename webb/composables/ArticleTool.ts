import { VisibleArticle } from "@/models/article/visibleArticle";
import { AdminArticleDetails } from "@/models/article/adminArticleDetails";

export function prepareCategories(article: AdminArticleDetails|VisibleArticle): string {
    let result = '';

    result = article.categories.toUpperCase().replaceAll(',', ' &centerdot; ');

    if (result) {
        result = `&centerdot; ${result} &centerdot;`;
    }

    return result;
}
