import Vue from 'vue'
import Router from 'vue-router'
import routes from './routes'
import mixin from "./mixin";

Vue.use(Router);
Vue.mixin(mixin);

export default new Router({
    mode: 'history',
    routes
});
