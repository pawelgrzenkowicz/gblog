import { useRuntimeConfig } from "nuxt/app";

import { small, medium } from "@/config/parameters";


const _formatsConfiguration: any = {
    'small': small,
    'medium': medium,
};

export class UseImageResize {
    constructor(
        private readonly formatsConfiguration: typeof _formatsConfiguration,
    ) {}

    resize(source: string, format: string): string {
        const IMAGE_HOST = useRuntimeConfig().public.IMAGE_HOST;

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
