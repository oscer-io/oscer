import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        config:{},
        flashMessages: []
    },
    mutations: {
        SET_CONFIG(state,config){
            state.config = config
        },
        ADD_FLASH_MESSAGE(state, message) {
            const index = state.flashMessages.push(message) - 1;
            setTimeout(() => {
                state.flashMessages.splice(Math.min(index, state.flashMessages.length - 1), 1)
            }, 2000);
        }
    },
    actions: {
        setConfig({commit}, config){
            commit('SET_CONFIG', config)
        },
        flash({commit}, message) {
            commit('ADD_FLASH_MESSAGE', message)
        }
    }
});
