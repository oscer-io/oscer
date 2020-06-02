import Vue from 'vue';
import api from '../api';
import {has} from 'lodash';

const resourceModule = {
    namespaced: true,
    state: {
        post: {},
        page: {},
    },
    mutations: {
        updateForm(state, data) {
            const id = 'id' in data.resource.model ? data.resource.model.id : 0

            has(state, [data.name, id])
                ? Vue.set(state[data.name][id], 'form', data.resource)
                : Vue.set(state[data.name], id, {form: data.resource})
        }
    },
    getters: {
        getForm: (state) => (data) => {
            const id = data.id !== null ? data.id : 0;

            return has(state, [data.name, id, 'form'])
                ? state[data.name][id].form
                : false
        }
    },
    actions: {
        async fetchForm(context, data) {
            const route = data.id !== null
                ? api.route('cms.backend.resources.show', [data.name, data.id])
                : api.route('cms.backend.resources.create', data.name);

            const response = await api.request(route);
            context.commit('updateForm', {name: data.name, resource: response.data.data})
        }
    }
};

export default resourceModule;
