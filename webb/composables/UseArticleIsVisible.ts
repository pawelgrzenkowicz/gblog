import { AdminArticleDetails } from "@/models/article/adminArticleDetails";

export function UseArticleIsVisible(article: AdminArticleDetails): boolean {
    const publicationDate = new Date(article.publicationDateFormatted);
    const now = new Date();

    return (
        article.ready.he &&
        article.ready.she &&
        !article.removed &&
        null !== article.publicationDate &&
        publicationDate <= now
    );
}
