import Vue from 'vue'
import {InertiaApp} from "@inertiajs/inertia-vue";
import VueI18n from 'vue-i18n';
import languageBundle from '@kirschbaum-development/laravel-translations-loader/php?parameters={{ $1 }}!@kirschbaum-development/laravel-translations-loader';
import Router from "../lib/Router";
import vClickOutside from "v-click-outside";

// global plugins
Vue.use(InertiaApp);
Vue.use(VueI18n);
Vue.use(vClickOutside);

const renderInertia = (h, componentPath) => {
    return h(InertiaApp, {
        props: {
            initialPage: JSON.parse(app.dataset.page),
            resolveComponent: name => require(`../${componentPath}/${name}`).default,
            transformProps: props => {
                return {
                    ...props,
                    routes: new Router(props.routes),
                }
            },
        },
    });
};

const i18n = new VueI18n({
    locale: window.locale,
    messages: languageBundle,
});


export {
    i18n,
    renderInertia,
}
