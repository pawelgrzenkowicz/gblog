import { Contents } from "@/models/article/contents";
import { Ready } from "@/models/article/ready";
import { Picture } from "@/models/article/picture";

export class AdminArticleDetails {
    public uuid: string;
    public contents: Contents;
    public createDate: string;
    public mainPicture: Picture;
    public slug: string;
    public title: string;
    public categories: string;
    public publicationDate: string|null;
    public ready: Ready;
    public removed: boolean;
    public views: number;
    public mainPictureName : string;
    public publicationDateFormatted: string;

    constructor(
        uuid: string,
        contents: Contents,
        createDate: string,
        mainPicture: Picture,
        slug: string,
        title: string,
        categories: string,
        publicationDate: string|null,
        ready: Ready,
        removed: boolean,
        views: number,
        mainPictureName: string,
        publicationDateFormatted: string,
    ) {
        this.uuid = uuid;
        this.contents = contents;
        this.createDate = createDate;
        this.mainPicture = mainPicture;
        this.slug = slug;
        this.title = title;
        this.categories = categories;
        this.publicationDate = publicationDate;
        this.ready = ready;
        this.removed = removed;
        this.views = views;

        this.mainPictureName = mainPictureName;
        this.publicationDateFormatted = publicationDateFormatted;
    }
}
