export class Picture {
    public source: string;
    public alt: string;
    public extension: string;

    constructor(source: string, alt: string, extension: string) {
        this.source = source;
        this.alt = alt;
        this.extension = extension;
    }
}
