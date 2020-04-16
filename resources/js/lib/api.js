import Vue from 'vue';
import axios from 'axios'
import router from './router'


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['X-CMS-BACKEND'] = true;
axios.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector(
    'meta[name="csrf-token"]'
).content;
axios.interceptors.response.use(
    response => response,
    error => {
        const {status} = error.response;

        // Show the user a 500 error
        if (status >= 500) {
            Vue.store.dispatch('flash', {
                type: 'error',
                text: error.response.data.message
            });
        }

        // Handle Session Timeouts
        if (status === 401 || status === 419) {
            window.location.href = '/admin'
        }

        // Handle Not Found
        if (status === 404) {
            router.push({name: 'not-found'})
        }

        return Promise.reject(error)
    }
);

const api = axios.create();

export default api
