
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

window.Vue = require('vue');
window.Vuetify = require('vuetify');
Vue.use(Vuetify);

import store from './store.js';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import Dashboard from './components/admin/Dashboard';
import Articles from './components/admin/Articles';
import Facts from './components/admin/Facts';
import Video from './components/admin/Video';
import Layout from './components/admin/Layout';
import Menu from './components/admin/Menu';

const router = new VueRouter({
    //mode: 'history',
    linkActiveClass: 'is-active',
    routes: [
        { path: '/', component: Menu,
            children: [
                { path: '/dashboard', component: Dashboard, name: 'dashboard' },
                { path: '/articles', component: Articles, name: 'articles' },
                { path: '/facts', component: Facts, name: 'facts' },
                { path: '/video', component: Video, name: 'video' },
            ]
        }
    ]
});

const app = new Vue({
    el: '#admin',
    router,
    store,
    render: h => h(Layout)
});
