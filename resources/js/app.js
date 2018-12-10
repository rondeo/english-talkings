
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueTables from 'vue-tables-2';
import vSelect from 'vue-select';


Vue.component('v-select', vSelect);
Vue.use(VueTables.ClientTable);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('main-component', require('./components/MainComponent.vue'));
Vue.component('world-map', require('./components/WorldMapComponent.vue'));
Vue.component('profile', require('./components/ProfileComponent.vue'));

const app = new Vue({
    el: '#app'
});
