import Vue from 'vue'
import Vuex from 'vuex'
import video from './modules/video'
import fact from './modules/fact'
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        fact,
        video
    },
    plugins: []
})