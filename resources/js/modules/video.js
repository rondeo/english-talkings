import Vue from 'vue'

const state = {
    videos: []
};


const actions = {
    getVideos({commit}){
        commit('getVideos');
    }
};

const mutations = {
    addVideo(state, { video }) {
        state.videos.push(video);
    },

    getVideos() {
       axios.get('api/videos')
            .then( response => state.videos = response.data.data);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
}