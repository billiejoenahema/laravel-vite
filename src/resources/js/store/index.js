import { createStore } from 'vuex';
import auth from './modules/auth';
import consts from './modules/consts';
import customers from './modules/customers';
import loading from './modules/loading';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    consts,
    customers,
    loading,
    profile,
  },
});
