import { Ref } from "vue";

export function prepareDateToSend(date: string): string {
    return date.slice(0, 16)
}

export function replaceWhitespace(text: string): string {
    return text.replaceAll(' ', '-');
}

export function showDate(date: string): string {
    let [datePart, timePart] = date.split('T');
    let [year, month, day] = datePart.split('-');

    return `${day}.${month}.${year}`;
}


export function showDateWithoutTimeZone(date: string): string {
    return date.split("+")[0];
}

export function truncateParagraphs(text: string): string {
    const matchAll = text.matchAll(/<p>.*?<\/p>/gm);
    const paragraphList = [...matchAll];
    let result: string = '';

    if (paragraphList) {
        const length = paragraphList.length > 4 ? 4 : paragraphList.length;
        for (let i = 0; i < length; i++) {
            result += paragraphList[i][0];
        }
    }

    return result;
}

export function replaceUnnecessaryCharacters(ref: Ref) {
    ref.value = ref.value.replace(/\s/g, '');
    ref.value = ref.value.toLowerCase();
    ref.value = ref.value.replace(/[ąćęłńóśźż]/g, '');

    const regexSpecialCharacters = /[!"#$%&'()*+,./:;<=>?@[\\\]^_{|}]/g;

    ref.value = ref.value.replace(regexSpecialCharacters, '');
}

