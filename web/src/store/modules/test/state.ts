import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export interface State {
    test: string;
    cos: string;
}

export default {
    namespaced: true,
    state: <State>{
        test: 'Test text.',
        cos: 'cos',
    },
    mutations,
    actions,
    getters,
}
