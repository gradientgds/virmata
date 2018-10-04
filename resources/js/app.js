
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import 'jquery-ui-dist/jquery-ui';

import 'admin-lte/plugins/datatables/dataTables.bootstrap4';

// import VueRouter from 'vue-router';
// Vue.use(VueRouter);

// import EasyUI from 'vx-easyui';
// Vue.use(EasyUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('test-button', require('./components/TestComponent.vue'));
Vue.component('admin-users-index', require('./components/AdminUsersIndex.vue'))

Vue.component('admin-users-show', require('./components/AdminUsersShow.vue'))

Vue.component('easy-ui-test', require('./components/tests/EasyuiComponent.vue'))

// Vue.component('invoice-row', require('./components/InvoiceRow.vue'));

Vue.component('sales-orders-create', require('./components/SalesOrdersCreate.vue'))

Vue.component('datepicker-input', require('./components/DatepickerInput.vue'))

Vue.component('account-table', require('./components/AccountTable.vue'))

// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/admin/users',
//             component: require('./components/AdminUsersIndex.vue'),
//         },
//         {
//             path: '/admin/users/:id',
//             component: require('./components/AdminUsersShow.vue'),
//             props: true,
//         },
//     ],
// });

const app = new Vue({
    el: '#app',
    // router,
});
