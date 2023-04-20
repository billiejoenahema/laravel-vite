import axios from 'axios';

const state = {
  errors: {},
};

const getters = {
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
  async login({ commit }, data) {
    await axios
      .get('http://localhost:8081/sanctum/csrf-cookie')
      .then(async (res) => {
        await axios
          .post('/login', data)
          .then(() => {
            console.log('success!');
            commit('setErrors', {});
          })
          .catch((err) => {
            commit(
              'setErrors',
              err.response.data.errors ?? err.response.data.message
            );
          });
      });
  },
  async logout({ commit }) {
    await axios
      .post('/logout')
      .then(() => {
        console.log('success!');
      })
      .catch((err) => {
        commit(
          'setErrors',
          err.response.data.errors ?? err.response.data.message
        );
      });
  },
  async forgotPassword({ commit }, data) {
    await axios
      .post('/api/forgot-password', data)
      .then(() => {
        console.log('success');
        commit('setErrors', {});
      })
      .catch((err) => {
        commit(
          'setErrors',
          err.response.data.errors ?? err.response.data.message
        );
      });
  },
  async resetPassword({ commit }, data) {
    await axios
      .post('/api/reset-password', data)
      .then(() => {
        console.log('success');
        commit('setErrors', {});
      })
      .catch((err) => {
        commit(
          'setErrors',
          err.response.data.errors ?? err.response.data.message
        );
      });
  },
};

const mutations = {
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
