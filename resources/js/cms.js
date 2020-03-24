
// 1. Define route components.
// These can be imported from other files
import VueRouter from "vue-router";
import Vue from 'vue';
import VueI18n from 'vue-i18n';
import languageBundle
    from '@kirschbaum-development/laravel-translations-loader/php?parameters={{ $1 }}!@kirschbaum-development/laravel-translations-loader';

const NotFound = { template: '<div>not found</div>' };
const Admin = { template: '<div>Admin index</div>' };

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
    { path: '/admin', component: Admin },
    { path: '/admin/pages', component: require('./views/Pages/Index').default },
    { path: '/admin/posts', component: require('./views/Posts/Index').default },
    { path: '/admin/menus', component: require('./views/Menus/Index').default },
    { path: '/admin/options', component: require('./views/Options/Index').default },
    { path: '/admin/users', component: require('./views/Users/Index').default },
    { path: '*', component: NotFound }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

Vue.use(VueI18n);

const i18n = new VueI18n({
    locale: window.locale,
    messages: languageBundle,
});

Vue.use(VueRouter)
Vue.component('NavbarLink', require('./components/NavbarLink').default);
Vue.component('Dropdown', require('./components/Dropdown').default);
// 4. Create and mount the root instance.
// Make sure to inject the router with the router option to make the
// whole app router-aware.
const app = new Vue({
    router,
    i18n
}).$mount('#cms')
