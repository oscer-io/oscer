import axios from 'axios';
import route from 'ziggy-js';
import router from './router';
import store from './store';

const api = axios.create();

api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
api.defaults.headers.common['X-CMS-BACKEND'] = true;
api.defaults.headers.common['X-CSRF-TOKEN'] = document.head.querySelector(
    'meta[name="csrf-token"]'
).content;
api.interceptors.response.use(
    response => response,
    error => {
        const {status} = error.response;

        // Show the user a 500 error
        if (status >= 500) {
            store.dispatch('flash', {
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

export default {
    request: api,
    /**
     * Generates an object which contains the method and the url needed for a request.
     * We use https://github.com/tightenco/ziggy for the generation. We only have
     * to alter the output that we have a simple object with url and method.
     */
    route(name, params, absolute) {
        const routeObject = route(name, params, absolute, store.state.config.routes);

        return {
            method: routeObject.urlBuilder.route.methods[0],
            url: routeObject.toString()
        }
    }
}
