import { Contents } from "@/models/article/contents";
import { Picture } from "@/models/article/picture";
import { Ready } from "@/models/article/ready";

export interface AdminArticleDetailsView {
    uuid: string;
    contents: Contents;
    createDate: string;
    mainPicture: Picture;
    slug: string;
    title: string;
    categories: string;
    publicationDate: string|null;
    ready: Ready;
    removed: boolean;
    views: number;

    mainPictureName: string,
    publicationDateFormatted: string,
}
