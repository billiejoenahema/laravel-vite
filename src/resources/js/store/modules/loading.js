const state = {
  loading: false,
};

const getters = {
  loading(state) {
    return state.loading;
  },
};

const mutations = {
  setLoading(state, bool) {
    state.loading = bool;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
