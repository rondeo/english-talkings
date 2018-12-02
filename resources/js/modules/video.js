import Vue from 'vue'

const state = {
    video: []
};


const actions = {
    getVideo({commit}){
        commit('getVideo');
    }
};

const mutations = {
    addVideo(state, { video }) {
        state.video.push(video);
    },

    getVideo() {
        Vue.prototype.$axios.get('video')
            .then( response => state.video = response.data.data);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
}