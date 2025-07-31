import { createStore } from "vuex";
import { API_HOST, IMAGE_HOST } from "@/../config/parameters";

import testModule from './modules/test/state';
import articleModule, { State as ArticleState } from './modules/article/state';
import userModule, { State as UserState } from './modules/user/state';
import { State as TestState } from "./modules/test/state";

export interface RootState {
    apiHost: string;
    article: ArticleState;
    imageHost: string;
    test: TestState;
    user: UserState;
}

const store = createStore({
    modules: {
        test: testModule,
        article: articleModule,
        user: userModule,
    },
    state: <RootState>{
        apiHost: API_HOST,
        imageHost: IMAGE_HOST
    },
});

export default store;
