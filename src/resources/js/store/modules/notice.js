import router from "@/router";
import axios from "axios";

const setLoading = (commit, bool) =>
  commit("loading/setLoading", bool, { root: true });

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
      if (acc === "") return cur;
      return `${acc}\n${cur}`;
    }, "");
  },
  isInvalid: (state) => (key) => {
    return state.errors?.[key] ? "is-invalid" : "";
  },
};

const actions = {
  async get({ commit }, id) {
    setLoading(commit, true);
    await axios
      .get(`/api/notices/${id}`)
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
  async post({ commit }, data) {
    setLoading(commit, true);
    await axios
      .post(`/api/notices`, data)
      .then((res) => {
        commit("setErrors", {});
        commit("setData", res);
        commit(
          "overlay/setData",
          {
            message: "登録しました",
            status: 200,
          },
          { root: true }
        );
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
  async patch({ commit }, data) {
    setLoading(commit, true);
    await axios
      .patch(`/api/notices/${data.id}`, data)
      .then((res) => {
        commit("setErrors", {});
        commit(
          "overlay/setData",
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit("setData", res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if (err.response.status === 401) {
          router.push("/login");
        }
        commit(
          "overlay/setData",
          {
            message: "エラー",
            status: err.response.status,
          },
          { root: true }
        );
        commit("setErrors", err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async delete({ commit }, id) {
    setLoading(commit, true);
    await axios
      .delete(`/api/notices/${id}`)
      .then((res) => {
        commit("setErrors", {});
        commit(
          "overlay/setData",
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit("setData", res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if (err.response.status === 401) {
          router.push("/login");
        }
        commit(
          "overlay/setData",
          {
            message: err.response.data.message,
            status: err.response.status,
          },
          { root: true }
        );
        commit("setErrors", err.response.data.errors);
      });
    setLoading(commit, false);
  },
  async restore({ commit }, id) {
    setLoading(commit, true);
    await axios
      .patch(`/api/notices/${id}/restore`)
      .then((res) => {
        commit("setErrors", {});
        commit(
          "overlay/setData",
          {
            message: res.data.message,
            status: res.status,
          },
          { root: true }
        );
        commit("setData", res);
      })
      .catch((err) => {
        // 認証エラーのときはログイン画面へ遷移させる
        if (err.response.status === 401) {
          router.push("/login");
        }
        // 404エラーのときは強制リロードさせる
        if (err.response.status === 404) {
          window.location.reload();
        }
        commit(
          "overlay/setData",
          {
            message: err.response.data.message,
            status: err.response.status,
          },
          { root: true }
        );
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
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
