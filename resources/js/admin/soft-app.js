import Vue from 'vue';
import router from './routes.js'
import BaseComponent  from './components/Base.vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css'
import axios from 'axios';
import {store} from './store/store';
import VueIziToast from 'vue-izitoast';
import 'izitoast/dist/css/iziToast.css';
import VeeValidate from 'vee-validate';
import VueMaterial from 'vue-material'
import 'vue-material/dist/vue-material.min.css'
import ToggleButton from 'vue-js-toggle-button'
import VueApexCharts from 'vue-apexcharts'

Vue.prototype.$axios = axios;
const api_token = localStorage.getItem('api_token');
if (api_token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer ' + api_token
}
Vue.use(Vuetify);
Vue.use(VueIziToast, {position: 'topCenter'});
Vue.use(VeeValidate);
Vue.use(VueMaterial);
Vue.use(ToggleButton);

Vue.component('apexchart', VueApexCharts)

new Vue({
    store: store,
    el: '#admin-app',
    router,
    components:
        {
            baseComponent: BaseComponent
        }
});
