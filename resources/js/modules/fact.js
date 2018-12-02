import Vue from 'vue'

const state = {
    facts: []
};


const actions = {
    getFacts({commit}){
        commit('getFacts');
    }
};

const mutations = {
    addFacts(state, { fact }) {
        state.fact.push(fact);
    },

    getFacts() {
        axios.get('api/facts').then( response => state.facts = response.data.data);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
}