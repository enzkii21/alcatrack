require('./bootstrap');
import Vue from 'vue'
import Vuetify from 'vuetify'
import Router from './router'
import store from './store'
import App from '../template/App.vue'
import CryptoJS from 'vue-cryptojs'
import moment from 'moment';
Vue.use(Vuetify)
Vue.use(CryptoJS)

const app = new Vue({
    el: '#app',
    store,
    router:Router,
    vuetify: new Vuetify(),
    render: h=>h(App)
});