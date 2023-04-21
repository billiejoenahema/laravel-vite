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
  <button type="button" @click="logout">ログアウト</button>
</template>
