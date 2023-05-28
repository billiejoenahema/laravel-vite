<script setup>
import InputSelectPrefecture from '@/components/InputSelectPrefecture.vue';
import { ref } from 'vue';
const pref = ref(13);
</script>

<template>
  <h2>Top Page</h2>
  <div class="mb-3">
    <router-link to="/customers">顧客一覧</router-link>
  </div>
  <InputSelectPrefecture id="prefecture" v-model="pref" />
</template>
