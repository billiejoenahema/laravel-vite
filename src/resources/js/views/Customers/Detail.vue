<script setup>
import { computed } from 'vue';
import router from '../../router';
import { store } from '../../store';

const customerId = router.currentRoute.value?.params?.id;
store.dispatch('customer/get', customerId);
const customer = computed(() => store.getters['customer/data']);
</script>

<template>
  <div>{{ customer.id }}</div>
</template>
