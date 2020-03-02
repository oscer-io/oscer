import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import Router from './Router';

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
