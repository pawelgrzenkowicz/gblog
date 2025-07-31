import { Contents } from "@/models/article/contents";
import { Picture } from "@/models/article/picture";

export interface VisibleArticlePOJO {
    uuid: string;
    contents: {
        he: string;
        she: string;
    };
    mainPicture: {
        source: string;
        alt: string;
        extension: string;
    };
    slug: string;
    title: string;
    views: number;
    categories: string;
    publicationDate: string;
}

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

    public toJSON() {
        return {
            uuid: this.uuid,
            contents: this.contents.toJSON(),
            mainPicture: this.mainPicture.toJSON(),
            slug: this.slug,
            title: this.title,
            views: this.views,
            categories: this.categories,
            publicationDate: this.publicationDate
        };
    }
}
