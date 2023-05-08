import { createStore } from 'vuex';
import auth from './modules/auth';
import consts from './modules/consts';
import customer from './modules/customer';
import customers from './modules/customers';
import loading from './modules/loading';
import profile from './modules/profile';

export const store = createStore({
  modules: {
    auth,
    consts,
    customer,
    customers,
    loading,
    profile,
  },
});
