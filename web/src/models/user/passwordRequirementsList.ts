import {PasswordRequirements} from "@/models/user/passwordRequirements";

export class PasswordRequirementsList {
    private readonly list = {};
    constructor() {
        this.list = this.generateList();
    }

    public getPasswordRequirements(): { [key: string]: PasswordRequirements } {
        return this.list;
    }

    private generateList(): { [key: string]: PasswordRequirements } {
        return {
            "minLenght": new PasswordRequirements("Musi być 8 znaków", false),
            "lowercaseCharacter": new PasswordRequirements("Musi być mała litera", false),
            "uppercaseCharacter": new PasswordRequirements("Musi być wielka litera", false),
            "specialCharacter": new PasswordRequirements("Musi być znak specjalny", false),
            "number": new PasswordRequirements("Musi być cyfra", false),
            "identical": new PasswordRequirements("Hasłą muszą być takie same", false),
        };
    }
}
