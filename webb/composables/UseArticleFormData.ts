import { prepareDateToSend, replaceWhitespace } from "@/composables/UseTextModifier";
import { Ref } from "vue";

export function prepare(
    formData: FormData,
    contentHe: string,
    contentShe: string,
    mainPictureAlt: string,
    mainPictureSource: string,
    readyHe: string,
    readyShe: string,
    slug: string,
    title: string,
    categories: string,
    views: string,
    removed: string,
    publicationDate: string,
    mainPictureFile: File|null
): FormData {
    formData.append('createDate', prepareDateToSend(new Date().toISOString()));
    formData.append('contents[he]', contentHe);
    formData.append('contents[she]', contentShe);

    formData.append('mainPicture[alt]', mainPictureAlt)
    formData.append('mainPicture[source]', replaceWhitespace(mainPictureSource))

    formData.append('ready[he]', readyHe);
    formData.append('ready[she]', readyShe);
    formData.append('slug', slug);

    formData.append('title', title);

    // if(categories.split(',').length > 0) {
    //     categories.split(',').forEach((category) => formData.append('categories[]', category))
    // } else {
    formData.append('categories', categories)
    // }

    formData.append('views', views);
    formData.append('removed', removed);
    formData.append('publicationDate', publicationDate ?? '');


    if (mainPictureFile) {
        formData.append('mainPictureFile', mainPictureFile);
    }

    return formData;
}

// function prepareCategories(formData: FormData, categories: Ref<string>): void {
//     if(categories.value.split(',').length > 0) {
//         categories.value.split(',').forEach((category) => formData.append('categories[]', category))
//     } else {
//         formData.append('categories[]', '')
//     }
// }

export function preparePictureSource(path: string, pictureName: string): string {
    const year = new Date().getFullYear();

    return `${path}/${year}/${pictureName}`;
}
