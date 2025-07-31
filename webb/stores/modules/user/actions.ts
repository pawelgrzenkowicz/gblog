import { State } from "@/stores/modules/user/state";
import axios from "axios";

import { mainStore } from "@/stores";
import userStore from "@/stores/modules/user";

function getState(): State {
    return userStore().$state
}

function parseToken(token: string) {
    return JSON.parse(
        atob(token.split('.')[1]),
    );
}

export default {
    async createUser(data: any) {

        // await state.dispatch('setIsLoading', true);
        this.setIsLoading(true)

        // JAK BEDZIESZ MIAŁ CZAS
        // AXIOS MUSI MIEĆ DODATKOWĄ LOGIKĘ BEFORE EACH REQUEST (REQUEST INTERCEPTOR)
        // JEŻELI TOKEN IS SET TO USTAW AUTHORIZATION, JEZELI NIE, TO NIE

        // I JEŻELI TOKEN JEST 30 SEKUND LUB MNIEJ DO EXPIRED, TO REFRESH

        try {
            const response = await axios.post(`${mainStore().hosts.apiHost}/api/users`, JSON.stringify(data));


            console.log(response.data);
            console.log('ok');
        } catch (e: any) {
            console.log('nie ok');
        }

        this.setIsLoading(false)
    },

    async logout(): Promise<void> {
        localStorage.removeItem('_t');
        localStorage.removeItem('_rt');

        this.setRoles([])
        this.setToken(null)
        this.setUserEmail(null)
    },

    async reload(): Promise<void> {
        if (!localStorage) {
            await this.logout()
        }

        const token = localStorage.getItem('_t');
        const refreshToken = localStorage.getItem('_rt');

        if (!token || !refreshToken) {
            await this.logout()
            return;
        }

        try {
            const { iat, exp, roles, username } = parseToken(token);

            if (!(exp >= 0) || !Array.isArray(roles) || !(typeof username === 'string')) {
                console.log("ERROR TOKEN");
                await this.logout()
            }

            const date = Date.now();

            if ((exp * 1000) < ((date) - 30000)) {
                await this.refresh(refreshToken)

                const token = localStorage.getItem('_t');

                if (null === token) {
                    return await this.logout()
                }

                const { iat, exp, roles, username } = parseToken(token);


                this.setUserEmail(username)
                this.setToken(token)
                this.setRoles(roles)
            } else {
                this.setUserEmail(username)
                this.setToken(token)
                this.setRoles(roles)
            }
        } catch (error) {
            console.log(error);
            console.log("ERROR LOGIN");

            await this.logout()
        }
    },

    async login(data: any): Promise<void> {
        if (!localStorage) {
            return console.log('[ERROR] Local storage not found. Impossible to log in.');
        }

        this.setIsLoading(true)

        try {

            const response = await axios.post(`${mainStore().hosts.apiHost}/api/login`, JSON.stringify(data) , {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            localStorage.setItem('_t', response.data.token);
            localStorage.setItem('_rt', response.data.refresh_token);

            await this.reload();
        } catch (e: any) {
            console.log(e);
            console.log('nie ok, logowanie');
            console.log('tutaj będą potrzebne zmiany, dodać obsługę błędu');
        }

        this.setIsLoading(false)
    },

    async refresh(refreshToken: string): Promise<void> {
        if (!localStorage) {
            return console.log('[ERROR] Local storage not found. Impossible to log in.');
        }

        this.setIsLoading(true)

        try {
            const response = await axios.post(`${mainStore().hosts.apiHost}/api/security/refresh`,
                JSON.stringify({"refresh_token": refreshToken}) ,
                {
                    headers: {
                        "Content-Type": "application/json",
                    },
            });

            localStorage.setItem('_t', response.data.token);

            await this.reload();
        } catch (e: any) {
            console.log(e);
            console.log('nie ok,refresh');
            localStorage.removeItem('_t');
            localStorage.removeItem('_rt');
        }

        this.setIsLoading(false)
    },

    setIsLoading(isLoading: boolean): void {
        getState().isLoading = isLoading
    },

    setRoles(roles: []): void {
        getState().roles = roles;
    },

    setToken(token: string|null): void {
        getState().token = token;
    },

    setUserEmail(userEmail: string|null): void {
        getState().userEmail = userEmail;
    },
};
