/** Main and 3rd-party components/tools **/
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';

/** Custom components **/
import Vuex from 'vuex';
import 'vue-awesome/icons';
import Msg from 'vue-message'
import * as axios from "axios";
import VueAxios from "vue-axios";
import BlockUI from 'vue-blockui';
import spinner from '../img/spinner.gif';
import Icon from 'vue-awesome/components/Icon';
import MainPageComponent from "./components/MainPageComponent";

/** Regular requires and defining Vue into the browser window to have access on demand (only for dev purpose) **/
require('./bootstrap');
window.Vue = Vue;

const store = new Vuex.Store({
    state: {
        blockUI: {
            message: null,
            url: spinner,
            visible : false
        }
    },
    mutations: {}
});

Vue.use(BlockUI);
Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);
Vue.use(Msg);

/** Axios Interceptors **/
axios.interceptors.request.use((req) => {
    store.state.blockUI.visible = true;
    store.state.blockUI.message = 'Please Wait...';

    return req;
}, () => {
    store.state.blockUI.visible = false;
        store.state.blockUI.message = null;
});

axios.interceptors.response.use((response) => {
    store.state.blockUI.visible = false;
        store.state.blockUI.message = null;
    return response;
}, (error) => {
    store.state.blockUI.visible = false;
        store.state.blockUI.message = null;
    return error;
});


Vue.component('v-icon', Icon);

const app = new Vue({
    store,
    el: '#app',
    render: h => h(MainPageComponent)
});
