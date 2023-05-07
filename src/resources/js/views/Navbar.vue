<script setup>
import { computed } from 'vue';
import router from '../router';
import { store } from '../store';

const isLoggedIn = computed(() => store.getters['profile/isLoggedIn']);
const logout = async () => {
  if (confirm('ログアウトしますか？')) {
    await store.dispatch('auth/logout');
    await store.commit('profile/setData', {});
    router.push('/login');
  }
};
</script>

<template>
  <nav class="navbar sticky-top navbar-dark bg-dark mb-3">
    <div class="container-fluid">
      <router-link to="/"
        ><div title="トップページ">Laravel Vite</div></router-link
      >
      <font-awesome-icon
        v-if="isLoggedIn"
        class="right-from-bracket-icon icon text-primary"
        icon="right-from-bracket"
        title="ログアウト"
        @click="logout"
      />
    </div>
  </nav>
</template>

<style scoped>
.container-fluid > a {
  text-decoration: none;
}
.icon {
  cursor: pointer;
}
</style>
