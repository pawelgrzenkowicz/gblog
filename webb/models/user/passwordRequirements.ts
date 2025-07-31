export class PasswordRequirements {
    private description: string;
    private isValid: boolean;

    constructor(description: string, isValid: boolean) {
        this.description = description;
        this.isValid = isValid;
    }

    getDescription(): string {
        return this.description;
    }

    public getIsValid(): boolean {
        return this.isValid;
    }

    public setIsValid(isValid: boolean): void {
        this.isValid = isValid;
    }
}
