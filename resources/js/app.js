import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import Router from './lib/Router';
import route from './mixins/route';

window.events = new Vue();
window.flash = function (type, text) {
    window.events.$emit('flash', {'type': type, 'text': text});
};

Vue.use(vClickOutside);
Vue.use(InertiaApp);
Vue.mixin(route);

const app = document.getElementById('app');


new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
            transformProps: props => {
                return {
                    ...props,
                    routes: new Router(props.routes),
                }
            },
        },
    }),
}).$mount(app);
