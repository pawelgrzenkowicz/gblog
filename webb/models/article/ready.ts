export class Ready {
    public he: boolean;
    public she: boolean;

    constructor(he: boolean, she: boolean) {
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
