<script setup>
import router from '@/router';
import { store } from '@/store';

const logout = async () => {
  if (confirm('ログアウトしますか？')) {
    await store.dispatch('auth/logout');
    await store.commit('profile/setData', {});
    router.push('/login');
  }
};
</script>

<template>
  <h2>Top Page</h2>
  <button class="btn btn-primary" type="button" @click="logout">
    ログアウト
  </button>
  <router-link to="/customers">顧客一覧</router-link>
</template>
