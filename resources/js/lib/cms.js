import Vue from 'vue';
import VueJSModal from 'vue-js-modal';
import router from './router';
import store from './store'
import i18n from './i18n';
import Layout from '../components/Layout';

export default class Cms {

    constructor(config) {
        this.bus = new Vue();
        this.bootingCallbacks = [];
        store.dispatch('setConfig', config)
        this.config = config;
    }

    /**
     * Register a callback to be called before Oscer starts
     */
    booting(callback) {
        this.bootingCallbacks.push(callback)
    }

    /**
     * Execute all of the booting callbacks.
     */
    boot() {
        this.bootingCallbacks.forEach(callback => callback(Vue, router));
        this.bootingCallbacks = []
    }

    /**
     * Start Oscer by calling each of the booting callbacks and create the underlying Vue instance.
     */
    start() {
        this.boot();

        // @TODO move this to a plugins module which can be loaded in app.js
        Vue.use(VueJSModal, {dynamic: true});

        this.app = new Vue({
            el: '#cms',
            components: {Layout},
            router,
            store,
            i18n,
            data() {
                return {
                    transitionName: 'fade'
                }
            },
            created() {
                this.$router.beforeEach((to, from, next) => {

                    const toDepth = to.path.split('/').length;
                    const fromDepth = from.path.split('/').length;
                    this.transitionName = toDepth < fromDepth ? 'slide-right' : 'slide-left';

                    next();
                });
            },
            render: function (h) {
                return h(Layout, {
                    props: {
                        transitionName: this.transitionName
                    }
                });
            }
        })
    }

    /**
     * Register a listener on the event bus
     */
    $on(...args) {
        this.bus.$on(...args)
    }

    /**
     * Emit an event via the event bus
     */
    $emit(...args) {
        this.bus.$emit(...args)
    }
}

