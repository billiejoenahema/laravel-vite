import router from '@/router';
import axios from 'axios';

const setLoading = (commit, bool) =>
  commit('loading/setLoading', bool, { root: true });

const defaultParams = {
  sort_key: 'id',
  is_asc: false,
  page: 1,
  per_page: 20,
  search_value: {},
};

const state = {
  data: [],
  // ディープコピーできるstructuredCloneを使用する
  params: structuredClone(defaultParams),
  errors: {},
};

const getters = {
  data(state) {
    return state.data?.data ?? [];
  },
  params(state) {
    return state.params ?? {};
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
  meta(state) {
    return {
      current_page: state.data?.meta?.current_page ?? 0,
      from: state.data?.meta?.from ?? 0,
      last_page: state.data?.meta?.last_page ?? 0,
      links: state.data?.meta?.links ?? [],
      to: state.data?.meta?.to ?? 0,
      total: state.data?.meta?.total ?? 0,
    };
  },
  tooltipContent: (state) => (id) => {
    const customer = state.data.data.find((c) => c.id === id);
    if (!customer) return '';
    return `ID: ${customer.id}\n名前: ${customer.name}\nふりがな: ${customer.name_kana}\n住所: ${customer.address}`;
  },
};

const actions = {
  async get({ commit }, params) {
    setLoading(commit, true);
    await axios
      .get('/api/customers', { params })
      .then((res) => {
        commit('setErrors', {});
        commit('setData', res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if(err.response.status === 401) {
          router.push('/login');
        }
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
  resetParams(state) {
    state.errors = {};
    // ディープコピーできるstructuredCloneを使用する
    state.params = structuredClone(defaultParams);
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
