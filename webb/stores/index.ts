import { defineStore } from 'pinia'
import { useRuntimeConfig } from "nuxt/app";

interface Hosts {
    apiHost: string;
    imageHost: string;
}

interface MainState {
    hosts: Hosts,
}

export const mainStore =  defineStore<'main', MainState>('main', {
    state: (): MainState => {
        const { API_HOST, IMAGE_HOST } = useRuntimeConfig().public;

        return {
            hosts: {
                apiHost: typeof API_HOST === 'string' ? API_HOST : '',
                imageHost: typeof IMAGE_HOST === 'string' ? IMAGE_HOST : ''
            }
        };
    },
})
