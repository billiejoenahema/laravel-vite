const TIMEOUT = 10000;

const state = {
  data: {},
};

const getters = {
  data(state) {
    return state.data;
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
    setTimeout(() => {
      state.data = {};
    }, TIMEOUT);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
