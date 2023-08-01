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
  async updateAvatar({ commit }, { id, file }) {
    setLoading(commit, true);
    const formData = new FormData();
    formData.append('avatar', file);
    await axios
      .post(`/api/customers/${id}/update-avatar`, formData)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'overlay/setData',
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit('setData', res);
      })
      .catch((err) => {
        commit(
          'overlay/setData',
          {
            message: 'エラー',
            status: err.response.status,
          },
          { root: true }
        );
        commit('setErrors', err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async deleteAvatar({ commit }, id) {
    setLoading(commit, true);
    await axios
      .delete(`/api/customers/${id}/delete-avatar`)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'overlay/setData',
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit('setData', res);
      })
      .catch((err) => {
        commit(
          'overlay/setData',
          {
            message: 'エラー',
            status: err.response.status,
          },
          { root: true }
        );
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
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit('setData', res);
      })
      .catch((err) => {
        commit(
          'overlay/setData',
          {
            message: 'エラー',
            status: err.response.status,
          },
          { root: true }
        );
        commit('setErrors', err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async delete({ commit }, id) {
    setLoading(commit, true);
    await axios
      .delete(`/api/customers/${id}`)
      .then((res) => {
        commit('setErrors', {});
        commit(
          'overlay/setData',
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit('setData', res);
      })
      .catch((err) => {
        commit(
          'overlay/setData',
          {
            message: err.response.data.message,
            status: err.response.status,
          },
          { root: true }
        );
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
