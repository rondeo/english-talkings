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
    addFact(state, { fact }) {
        state.facts.push(fact);
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