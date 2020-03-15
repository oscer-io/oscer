import Vue from 'vue';
import route from '../mixins/route';
import {InertiaApp} from "@inertiajs/inertia-vue";
import Router from "./Router";
import vClickOutside from "v-click-outside";
import VueI18n from 'vue-i18n';
import languageBundle
    from '@kirschbaum-development/laravel-translations-loader/php?parameters={{ $1 }}!@kirschbaum-development/laravel-translations-loader';

export default new Vue({
    data() {
        return {
            config: {
                el: null,
            },
            bootingCallbacks: [],
            bootedCallbacks: [],
        }
    },

    methods: {
        // Run before laravelCms instance has been started
        booting(callback) {
            this.bootingCallbacks.push(callback);
        },

        // Run after laravelCms instance has been started
        booted(callback) {
            this.bootedCallbacks.push(callback);
        },

        setContainer(element) {
            this.config.el = element;
            return this;
        },

        start() {
            this.bootingCallbacks.forEach(callback => callback(this));
            this.bootingCallbacks = [];

            // run LaravelCms
            this.$app = new Vue(this.config);

            this.bootedCallbacks.forEach(callback => callback(this));
            this.bootedCallbacks = [];
        },

        loadMixins() {
            Vue.mixin(route);
            return this;
        },

        loadDirectives() {
            Vue.use(vClickOutside);
            return this;
        },

        loadBaseComponents() {
            const baseComponents = require.context('../components', true, /Base[A-Z]\w+\.(vue|js)$/);
            baseComponents.keys().forEach(fileName => {
                const baseComponent = baseComponents(fileName);
                const baseComponentName = baseComponent.name || (
                    fileName
                        .split('/')
                        .pop()
                        .replace(/\.\w+$/, '')
                );
                Vue.component(
                    baseComponentName,
                    baseComponent.default || baseComponent
                )
            });
            return this;
        },

        registerFlash() {
            window.events = new Vue();
            window.flash = (type, text) => {
                window.events.$emit('flash', {'type': type, 'text': text});
            };
            return this;
        },

        activateInertia() {
            Vue.use(InertiaApp);

            this.config.render = (h) => {
                return h(InertiaApp, {
                    props: {
                        initialPage: JSON.parse(app.dataset.page),
                        resolveComponent: name => require(`../views/${name}`).default,
                        transformProps: props => {
                            return {
                                ...props,
                                routes: new Router(props.routes),
                            }
                        },
                    },
                });
            };
            return this;
        },

        activateInternationalization() {
            Vue.use(VueI18n);

            this.config.i18n = new VueI18n({
                locale: window.locale,
                messages: languageBundle,
            });
            return this;
        },
    }
});
