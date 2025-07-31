import { ActionContext } from "vuex";
import { State } from "@/store/modules/user/state";
import { RootState } from "@/store";
import axios from "axios";

function parseToken(token: string) {
    return JSON.parse(
        atob(token.split('.')[1]),
    );
}

export default {
    async createUser(context: ActionContext<State, RootState>, data: any) {

        await context.dispatch('setIsLoading', true);

        // JAK BEDZIESZ MIAŁ CZAS
        // AXIOS MUSI MIEĆ DODATKOWĄ LOGIKĘ BEFORE EACH REQUEST (REQUEST INTERCEPTOR)
        // JEŻELI TOKEN IS SET TO USTAW AUTHORIZATION, JEZELI NIE, TO NIE

        // I JEŻELI TOKEN JEST 30 SEKUND LUB MNIEJ DO EXPIRED, TO REFRESH

        try {
            const response = await axios.post(`${context.rootState.apiHost}/api/users`, JSON.stringify(data));


            console.log(response.data);
            console.log('ok');
        } catch (e: any) {
            console.log('nie ok');
        }

        await context.dispatch('setIsLoading', false);
    },

    async logout(context: ActionContext<State, RootState>): Promise<void> {
        localStorage.removeItem('_t');
        localStorage.removeItem('_rt');

        await context.dispatch('setRoles', []);
        await context.dispatch('setToken', null);
        await context.dispatch('setUserEmail', null);
    },

    async reload(context: ActionContext<State, RootState>): Promise<void> {
        if (!localStorage) {
            return await context.dispatch('logout');
        }

        const token = localStorage.getItem('_t');
        const refreshToken = localStorage.getItem('_rt');

        if (!token || !refreshToken) {
            return await context.dispatch('logout');
        }

        try {
            const { iat, exp, roles, username } = parseToken(token);

            if (!(exp >= 0) || !Array.isArray(roles) || !(typeof username === 'string')) {
                console.log("ERROR TOKEN");
                return await context.dispatch('logout');
            }

            const date = Date.now();

            if ((exp * 1000) < ((date) - 30000)) {
                await context.dispatch('refresh', refreshToken);

                const token = localStorage.getItem('_t');

                if (null === token) {
                    return await context.dispatch('logout');
                }

                const { iat, exp, roles, username } = parseToken(token);

                await context.dispatch('setUserEmail', username);
                await context.dispatch('setToken', token);
                await context.dispatch('setRoles', roles);
            } else {
                await context.dispatch('setUserEmail', username);
                await context.dispatch('setToken', token);
                await context.dispatch('setRoles', roles);
            }
        } catch (error) {
            console.log(error);
            console.log("ERROR LOGIN");
            return await context.dispatch('logout');
        }
    },

    async login(context: ActionContext<State, RootState>, data: any): Promise<void> {
        if (!localStorage) {
            return console.log('[ERROR] Local storage not found. Impossible to log in.');
        }

        await context.dispatch('setIsLoading', true);

        try {
            const response = await axios.post(`${context.rootState.apiHost}/api/login`, JSON.stringify(data) , {
                headers: {
                    "Content-Type": "application/json",
                },
            });

            localStorage.setItem('_t', response.data.token);
            localStorage.setItem('_rt', response.data.refresh_token);

            await context.dispatch('reload');
        } catch (e: any) {
            console.log('nie ok, logowanie');
        }

        await context.dispatch('setIsLoading', false);
    },

    async refresh(context: ActionContext<State, RootState>, refreshToken: string): Promise<void> {
        if (!localStorage) {
            return console.log('[ERROR] Local storage not found. Impossible to log in.');
        }

        console.log(refreshToken);
        // await context.dispatch('setIsLoading', true);

        try {
            const response = await axios.post(`${context.rootState.apiHost}/api/security/refresh`,
                JSON.stringify({"refresh_token": refreshToken}) ,
                {
                    headers: {
                        "Content-Type": "application/json",
                        // "Authorization": `Bearer ${context.rootState.user.token}`,
                    },
            });

            localStorage.setItem('_t', response.data.token);

            await context.dispatch('reload');

            // await context.dispatch('setToken', response.data['token']);
            // const token = response.data['token'].split('.')[1];
            // const tokenObject = JSON.parse(atob(token));
            // await context.dispatch('setUserEmail', tokenObject.username);
            // await context.dispatch('setRoles', tokenObject.roles);
        } catch (e: any) {

            console.log(e);
            console.log('nie ok,refresh');
            localStorage.removeItem('_t');
            localStorage.removeItem('_rt');
        }

        // await context.dispatch('setIsLoading', false);
    },

    setIsLoading(context: ActionContext<State, RootState>, isLoading: boolean): void {
        context.commit('setIsLoading', isLoading)
    },

    setRoles(context: ActionContext<State, RootState>, roles: []): void {
        context.commit('setRoles', roles);
    },

    setToken(context: ActionContext<State, RootState>, token: string): void {
        context.commit('setToken', token);
    },

    setUserEmail(context: ActionContext<State, RootState>, userEmail: string): void {
        context.commit('setUserEmail', userEmail);
    },
};
