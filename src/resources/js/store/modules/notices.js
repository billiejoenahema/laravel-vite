import router from "@/router";
import axios from "axios";

const setLoading = (commit, bool) =>
  commit("loading/setLoading", bool, { root: true });

const defaultParams = {
  page: 1,
  per_page: 20,
  unread_only: false,
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
  isReadClassValue: (state) => (bool) => {
    console.log(bool);
    return bool ? "is-read" : "";
  },
};

const actions = {
  async get({ commit }, params) {
    setLoading(commit, true);
    await axios
      .get("/api/notices", { params })
      .then((res) => {
        commit("setErrors", {});
        commit("setData", res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if (err.response.status === 401) {
          router.push("/login");
        }
        commit("setErrors", err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async setAllRead({ commit }) {
    setLoading(commit, true);
    await axios
      .patch("/api/notices/set-all-read")
      .then((res) => {
        commit("setErrors", {});
        commit("setData", res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if (err.response.status === 401) {
          router.push("/login");
        }
        commit("setErrors", err.response.data.errors);
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
