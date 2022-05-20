// store/index.js

import Vue from "vue";
import Vuex from "vuex";
import axios from "axios";



export default new Vuex.Store({


    state: {
        async created() {
            const response = await axios.get('https://rfm.gmu.online/api/rfms').then(resp => {
                resp.data;
            })
        }
    },
    getters: {},
    mutations: {},
    actions: {}
});
