import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import Router from './Router';

Vue.use(vClickOutside);
Vue.use(InertiaApp);

const app = document.getElementById('app');

Vue.mixin(Router);
new Vue({
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./Pages/${name}`).default,
        },
    }),
}).$mount(app);
