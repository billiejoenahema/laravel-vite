import { createStore } from "vuex";
import auth from "./modules/auth";
import consts from "./modules/consts";
import customer from "./modules/customer";
import customers from "./modules/customers";
import loading from "./modules/loading";
import notice from "./modules/notice";
import notices from "./modules/notices";
import overlay from "./modules/overlay";
import profile from "./modules/profile";
import toast from "./modules/toast";

export const store = createStore({
  modules: {
    auth,
    consts,
    customer,
    customers,
    loading,
    notice,
    notices,
    profile,
    overlay,
    toast,
  },
});
