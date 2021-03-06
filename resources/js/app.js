/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

Vue.prototype.$eventBus = new Vue();

// Install BootstrapVue
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);

import 'bootstrap/dist/css/bootstrap.css';
//import 'bootstrap-vue/dist/bootstrap-vue.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('insert-expenses', require('./components/InsertExpenses.vue').default);
Vue.component('insert-incomes', require('./components/InsertIncomes.vue').default);
Vue.component('flash-message', require('./components/FlashMessage.vue').default);
Vue.component('month-picker', require('./components/MonthPicker.vue').default);
Vue.component('delete-type', require('./components/DeleteType.vue').default);
Vue.component('delete-lists', require('./components/DeleteLists.vue').default);
Vue.component('show-type', require('./components/ShowType.vue').default);
Vue.component('type-list', require('./components/TypeList.vue').default);
Vue.component('flash-box', require('./components/FlashBox.vue').default);
Vue.component('anual-table', require('./components/AnualTable.vue').default);
Vue.component('pie-chart', require('./components/PieChart.vue').default);
Vue.component('delete-source', require('./components/DeleteSource.vue').default);
Vue.component('delete-group', require('./components/DeleteGroup.vue').default);
Vue.component('payment-modal', require('./components/PaymentModal.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
