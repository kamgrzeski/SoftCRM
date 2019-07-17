import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.use(Vuex);
Vue.use(VueAxios, axios);

export const store = new Vuex.Store({
    state: {
        contentData: {
            counts: {},
            data: {},
            statistics: {}
        },
        token: localStorage.getItem('api_token') || '',
        adminId: null
    },

    getters: {},

    mutations: {
        loadContentData(state, contentData) {
            state.contentData = contentData
        },
    },
    actions: {
        getContentData: ({commit, dispatch}) => {
            axios
                .get(`./api/admin/content`)
                .then(response => {
                    return response.data
                })
                .then(contentData => {
                    commit('loadContentData', contentData)
                })
                .catch((error, response) => {
                    if (error.response.status === 422) {
                        this.message = error.response.data.message;
                    } else if (error.response.data.error.message) {
                        this.message = error.response.data.error.message;
                    } else {
                        this.message = 'ERROR. Connection with server has been lost. The changes have not been saved.';
                    }
                })
        },
    }

});

