<script setup>
import InputSelectPrefecture from '@/components/InputSelectPrefecture.vue';
import router from '@/router';
import { store } from '@/store';
import { ref } from 'vue';

const pref = ref(13);
const moveToCustomerIndex = () => {
  store.commit('customers/resetParams');
  router.push('/customers');
};
</script>

<template>
  <h2>Top Page</h2>
  <div class="mb-3">
    <span class="text-link" @click="moveToCustomerIndex">顧客一覧</span>
  </div>
  <InputSelectPrefecture id="prefecture" v-model="pref" />
</template>
