import Vue from 'vue';
import router from "./router";
import i18n from './i18n';
import Loading from '../components/Loading';
import Dropdown from '../components/Dropdown';
import NavbarLink from '../components/NavbarLink';
import Flash from "../components/Flash";

export default class Cms {

    constructor(config) {
        this.bus = new Vue();
        this.bootingCallbacks = [];
        this.config = config;
    }

    /**
     * Register a callback to be called before Laravel CMS starts
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
     * Start Laravel CMS by calling each of the booting callbacks and create the underlying Vue instance.
     */
    start() {
        this.boot();

        this.app = new Vue({
            el: '#cms',
            router,
            i18n,
            components: {
                Dropdown,
                Loading,
                NavbarLink,
                Flash
            },
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
        })
    }

    /**
     * Register a listener on the event bus
     */
    $on(...args) {
        this.bus.$on(...args)
    }

    /**
     * flash a message via the event bus
     */
    flash(type, text) {
        this.bus.$emit('flash', {'type': type, 'text': text});
    }
}

