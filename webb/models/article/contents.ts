export class Contents {
    public he: string;
    public she: string;

    constructor(he: string, she: string) {
        this.he = he;
        this.she = she;
    }

    public toJSON() {
        return {
            he: this.he,
            she: this.she
        };
    }
}
