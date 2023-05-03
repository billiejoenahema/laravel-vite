import { store } from '@/store/index';
import CustomerIndex from '@/views/Customers/Index.vue';
import Login from '@/views/Login.vue';
import PasswordReset from '@/views/PasswordReset.vue';
import Top from '@/views/Top.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    component: Top,
    meta: { isPublic: false },
  },
  {
    path: '/customers',
    component: CustomerIndex,
    meta: { isPublic: false },
  },
  {
    path: '/login',
    component: Login,
    meta: { isPublic: true },
  },
  {
    path: '/password-reset',
    component: PasswordReset,
    meta: { isPublic: true },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

router.beforeEach(async (to, _from, next) => {
  await store.dispatch('profile/getIfNeeded');

  const isLoggedIn = store.getters['profile/isLoggedIn'];
  if (isLoggedIn && to.path === '/login') {
    // ログイン中にログインページにアクセスしたらトップページにリダイレクトさせる
    next('/');
  } else if (!to.meta.isPublic && !isLoggedIn) {
    // ログインせずに非公開ページにアクセスしたらログインページにリダイレクトさせる
    next('/login');
  } else {
    store.dispatch('consts/getIfNeeded');
    next();
  }
});

router.afterEach(() => {
  resetErrors();
});

// エラーメッセージを初期化
const resetErrors = () => {
  store.commit('auth/setErrors', {});
};

export default router;
