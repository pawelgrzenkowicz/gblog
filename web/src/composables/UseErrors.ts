export interface ErrorsObject {
    [key: string]: Errors
}

interface ErrorsValues {
    [key: string]: any
}

class Error {
    public message: string;

    constructor(message: string) {
        this.message = message;
    }
}

class Errors {
    public errors: Error[] = [];
    constructor() {
        this.errors = [];
    }

    addError(error: Error) {
        this.errors.push(error);
    }
}

export class UseErrors {
    errors(e: Object): ErrorsObject {
        let mainErrors: ErrorsObject = {};
        const errorsValues: Object = Object.values(e)[0];

        this.prepare(mainErrors, errorsValues);

        return mainErrors;
    }

    private prepare(mainErrors: ErrorsObject, errorsValues: ErrorsValues, key: string|null = null): void {
        for (let errorKey of Object.keys(errorsValues)) {
            if (Array.isArray(errorsValues[errorKey])) {
                key = key ? key : '';
                this.addDisplayedError(mainErrors, errorsValues, key+errorKey, errorKey)
            } else if (errorsValues[errorKey] instanceof Object) {
                this.prepare(mainErrors, errorsValues[errorKey], errorKey+'-');
            }
        }
    }

    private addDisplayedError(mainErrors: ErrorsObject, errorsValues: ErrorsValues, newKey: string, key: string): void {
        let errors = new Errors();

        errorsValues[key].forEach((message: string) => {
            errors.addError(new Error(message))
        })

        mainErrors[newKey] = errors;
    }
}
