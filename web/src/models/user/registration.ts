export class Registration {
    public email: string;
    public nickname: string;
    public password: string;
    public plainPassword: string;

    constructor(email: string, nickname: string, password: string, plainPassword: string) {
        this.email = email;
        this.nickname = nickname;
        this.password = password;
        this.plainPassword = plainPassword;
    }
}
