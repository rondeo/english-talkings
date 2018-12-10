import Vue from 'vue'

const state = {
    articles: []
};


const actions = {
    getArticles({commit}){
        commit('getArticles');
    }
};

const mutations = {
    addArticle(state, { article }) {
        state.articles.push(article);
    },

    getArticles() {
        axios.get('api/articles').then( response => state.articles = response.data.data);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
}