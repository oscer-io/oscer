import Vue from 'vue';

export default new Vue({
    data() {
        return {
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

        app(app) {
            this.$app = app;
        },

        start() {
            this.bootingCallbacks.forEach(callback => callback(this));
            this.bootingCallbacks = [];

            // run LaravelCms
            this.$app = new Vue(this.$app);

            this.bootedCallbacks.forEach(callback => callback(this));
            this.bootedCallbacks = [];
        },

        component(name, component) {
            Vue.component(name, component);
        }
    }
});
