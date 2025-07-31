import { Contents } from "@/models/article/contents";
import { Picture } from "@/models/article/picture";

export class VisibleArticle {
    public uuid: string;
    public contents: Contents;
    public mainPicture: Picture;
    public slug: string;
    public title: string;
    public views: number;
    public categories: string;
    public publicationDate: string;

    constructor(
        uuid: string,
        contents: Contents, 
        mainPicture: Picture,
        slug: string, 
        title: string,
        views: number,
        categories: string,
        publicationDate: string,
    ) {
        this.uuid = uuid;
        this.contents = contents;
        this.mainPicture = mainPicture;
        this.slug = slug;
        this.title = title;
        this.views = views;
        this.categories = categories;
        this.publicationDate = publicationDate;
    }
}
