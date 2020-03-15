import Vue from 'vue'
import LaravelCms from './bootstrap/LaravelCms.js';

// Bootstrap globals
const mixins = require('./bootstrap/mixins');
const plugins = require('./bootstrap/plugins');

window.Vue = Vue;
window.LaravelCms = LaravelCms;
window.events = new Vue();
window.flash = (type, text) => {
    window.events.$emit('flash', {'type': type, 'text': text});
};

LaravelCms.app({
    el: '#app',

    i18n: plugins.i18n,

    render: h => plugins.renderInertia(h, 'views'),
});

LaravelCms.start();
