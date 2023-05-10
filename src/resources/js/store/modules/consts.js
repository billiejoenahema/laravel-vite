import axios from 'axios';

const state = {
  data: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  genderFormOptions(state) {
    return state.data?.GENDER;
  },
  prefectureFormOptions(state) {
    return state.data?.PREFECTURE;
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get('/api/const')
      .then((res) => {
        commit('setData', res.data);
      })
      .catch((err) => {
        console.log(err);
      });
  },
  async getIfNeeded({ dispatch, getters }) {
    if (Object.keys(getters.data).length) return;
    await dispatch('get');
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
