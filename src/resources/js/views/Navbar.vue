<script setup>
import router from "@/router";
import { store } from "@/store";
import { computed } from "vue";

const isLoggedIn = computed(() => store.getters["profile/isLoggedIn"]);
const unreadNoticeCount = computed(
  () => store.getters["profile/unreadNoticeCount"]
);
const profile = computed(() => store.getters["profile/data"]);
const logout = async () => {
  if (confirm("ログアウトしますか？")) {
    await store.dispatch("auth/logout");
    await store.commit("profile/setData", {});
    router.push("/login");
  }
};
</script>

<template>
  <nav class="navbar sticky-top navbar-dark bg-dark mt-2 mb-3">
    <div class="container-fluid">
      <router-link to="/">
        <div title="トップページ">Laravel Vite</div>
      </router-link>
      <div v-if="isLoggedIn">
        <router-link to="/notices" class="position-relative me-5">
          お知らせ
          <span
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
          >
            {{ unreadNoticeCount }}
            <span class="visually-hidden">unread messages</span>
          </span>
        </router-link>
        <router-link to="/profile" class="position-relative me-5">
          {{ profile.name }}
        </router-link>
        <font-awesome-icon
          class="right-from-bracket-icon icon text-primary"
          icon="right-from-bracket"
          title="ログアウト"
          @click="logout"
        />
      </div>
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
