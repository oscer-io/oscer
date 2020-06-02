import Vue from 'vue';

Vue.component('Loading', require('./Loading').default);
Vue.component('Dropdown', require('./Dropdown').default);
Vue.component('NavbarLink', require('./NavbarLink').default);
Vue.component('Flash', require('./Flash').default);
Vue.component('Tag', require('./Tag').default);

Vue.component('Tab', require('./Tab').default);
Vue.component('Tabs', require('./Tabs').default);

Vue.component('ResourceForm', require('./ResourceForm').default);
Vue.component('StoreResourceForm', require('./StoreResourceForm').default);
Vue.component('ResourceDetails', require('./ResourceDetails').default);
Vue.component('ResourceIndex', require('./ResourceIndex').default);

import './fields';
