export class Pagination {
    public limit: number;
    public page: number;

    constructor(page: number, limit: number) {
        this.limit = limit;
        this.page = page;
    }
}
