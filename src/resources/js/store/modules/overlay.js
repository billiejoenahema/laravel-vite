import { scrollToTop } from "@/utils/scrollToTop.js";

const TIMEOUT = 2000;
const initialData = {
  message: "",
  status: "",
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
      if (state.data.status === 200) {
        scrollToTop();
      }
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
