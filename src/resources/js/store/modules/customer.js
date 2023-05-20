import axios from 'axios';

const setLoading = (commit, bool) =>
  commit('loading/setLoading', bool, { root: true });

const state = {
  data: {},
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? {};
  },
  hasErrors(state) {
    return Object.keys(state.errors).length > 0;
  },
  invalidFeedback: (state) => (key) => {
    return state.errors?.[key]?.reduce((acc, cur) => {
      if (acc === '') return cur;
      return `${acc}\n${cur}`;
    }, '');
  },
  isInvalid: (state) => (key) => {
    return state.errors?.[key] ? 'is-invalid' : '';
  },
};

const actions = {
  async get({ commit }, id) {
    setLoading(commit, true);
    await axios
      .get(`/api/customers/${id}`)
      .then((res) => {
        commit('setErrors', {});
        commit('setData', res);
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async patch({ commit }, data) {
    setLoading(commit, true);
    await axios
      .patch(`/api/customers/${data.id}`, data)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'overlay/setData',
          {
            message: res.message ?? res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit('setData', res);
      })
      .catch((err) => {
        commit('setErrors', err.response.data.errors);
      });
    setLoading(commit, false);
  },
};

const mutations = {
  setData(state, data) {
    state.data = data.data;
  },
  setErrors(state, data) {
    state.errors = {};
    state.errors = data;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
