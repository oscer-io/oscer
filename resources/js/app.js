import { InertiaApp } from '@inertiajs/inertia-vue'
import Vue from 'vue'
import vClickOutside from 'v-click-outside'
import Router from './lib/Router';
import route from './mixins/route';

window.events = new Vue();
window.flash = function (type, text) {
    window.events.$emit('flash', {'type': type, 'text': text});
};

import languageBundle from '@kirschbaum-development/laravel-translations-loader/php?parameters={{ $1 }}!@kirschbaum-development/laravel-translations-loader';
import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: window.locale,
    messages: languageBundle,
});

Vue.use(vClickOutside);
Vue.use(InertiaApp);
Vue.mixin(route);

const app = document.getElementById('app');

new Vue({
    i18n,
    render: h => h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`./views/${name}`).default,
            transformProps: props => {
                return {
                    ...props,
                    routes: new Router(props.routes),
                }
            },
        },
    }),
}).$mount(app);
