import Vue from 'vue'
import Vuex from 'vuex'
import video from './modules/video'
import fact from './modules/fact'
import article from './modules/article'
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        fact,
        video,
        article,
    },
    plugins: []
})