import { IMAGE_HOST } from "../../config/parameters";
import { small } from "../../config/parameters";
import { medium } from "../../config/parameters";

const _formatsConfiguration: any = {
    'small': small,
    'medium': medium,
};

export class UseImageResize {
    constructor(
        private readonly formatsConfiguration: typeof _formatsConfiguration,
    ) {}

    resize(source: string, format: string): string {
        return `${IMAGE_HOST}/${format}/${source}`;
    }

    srcset(source: string, formats: string[]): Array<[string, number]> {
        return formats.map(
            (format: string) => {
                const width: number = this.formatsConfiguration[format];
                return [this.resize(source, format), width];
            },
        );
    }
}
