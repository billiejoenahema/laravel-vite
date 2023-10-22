import axios from "axios";

const setLoading = (commit, bool) =>
  commit("loading/setLoading", bool, { root: true });

const state = {
  data: {},
  errors: {},
};

const getters = {
  data(state) {
    return state.data;
  },
  isLoggedIn(state) {
    return state.data?.id > 0;
  },
  isAdmin(state) {
    return state.data?.is_admin;
  },
  hasErrors(state) {
    return Object.keys(state.errors)?.length > 0;
  },
  errors(state) {
    return state.errors ?? {};
  },
  invalidFeedback: (state) => (key) => {
    return state.errors?.[key]?.reduce((acc, cur) => {
      if (acc === "") return cur;
      return `${acc}\n${cur}`;
    }, "");
  },
  isInvalid: (state) => (key) => {
    return state.errors?.[key] ? "is-invalid" : "";
  },
  unreadNoticeCount(state) {
    const count = state.data?.unread_notice_count ?? 0;
    return count < 100 ? count : "99+";
  },
};

const actions = {
  async get({ commit }) {
    setLoading(commit, true);
    await axios
      .get("/api/profile")
      .then((res) => {
        commit("setErrors", {});
        commit("setData", res.data);
      })
      .catch((err) => {
        commit("setErrors", err.message);
        commit("setData", {});
      });
    setLoading(commit, false);
  },
  async getIfNeeded({ dispatch, getters }) {
    if (getters.isLoggedIn) return;
    await dispatch("get");
  },
  async post({ commit }, data) {
    setLoading(commit, true);
    delete data.last_login_at;
    await axios
      .post("/api/profile", data)
      .then(() => {
        commit("setErrors", {});
      })
      .catch((err) => {
        commit("setErrors", err.response.data.errors);
      });
    setLoading(commit, false);
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
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
