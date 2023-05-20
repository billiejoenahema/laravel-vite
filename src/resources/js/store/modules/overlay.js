const TIMEOUT = 3000;
const initialData = {
  message: '',
  status: '',
};

const state = {
  data: { ...initialData },
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
      state.data = { ...initialData };
    }, TIMEOUT);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
};
