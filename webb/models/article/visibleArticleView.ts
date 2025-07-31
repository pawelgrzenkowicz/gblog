import { Contents } from "@/models/article/contents";
import { Picture } from "@/models/article/picture";

export interface VisibleArticleView {
    uuid: string;
    contents: Contents;
    mainPicture: Picture;
    slug: string;
    title: string;
    views: number,
    categories: string,
    publicationDate: string;
}
