import { createStore } from 'vuex';
import auth from './modules/auth';
import customers from './modules/customers';
import loading from './modules/loading';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    loading,
    profile,
    customers,
  },
});
