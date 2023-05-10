<script setup>
import { formatDate } from '@/utils/formatter';
import { computed } from 'vue';
import router from '../../router';
import { store } from '../../store';

const customerId = router.currentRoute.value?.params?.id;
store.dispatch('customer/get', customerId);
const customer = computed(() => store.getters['customer/data']);
</script>

<template>
  <router-link to="/customers">一覧に戻る</router-link>
  <div class="customer-detail">
    <div class="row">
      <label class="col-3">顧客ID</label>
      <span class="col-9">{{ customer.id }}</span>
    </div>
    <div class="row">
      <label class="col-3">氏名</label>
      <span class="col-9">{{ customer.name }}</span>
    </div>
    <div class="row">
      <label class="col-3">ふりがな</label>
      <span class="col-9">{{ customer.name_kana }}</span>
    </div>
    <div class="row">
      <label class="col-3">年齢</label>
      <span class="col-9">{{ customer.age }}</span>
    </div>
    <div class="row">
      <label class="col-3">性別</label>
      <span class="col-9">{{ customer.gender_value }}</span>
    </div>
    <div class="row">
      <label class="col-3">電話番号</label>
      <span class="col-9">{{ customer.phone }}</span>
    </div>
    <div class="row">
      <label class="col-3">生年月日</label>
      <span class="col-9">{{ formatDate(customer.birth_date) }}</span>
    </div>
    <div class="row">
      <label class="col-3">住所</label>
      <span class="col-9">{{ customer.address }}</span>
    </div>
    <div class="row">
      <label class="col-3">登録日</label>
      <span class="col-9">{{ formatDate(customer.created_at) }}</span>
    </div>
    <div class="row">
      <label class="col-3">更新日</label>
      <span class="col-9">{{ formatDate(customer.updated_at) }}</span>
    </div>
  </div>
</template>

<style scoped>
.customer-detail {
  max-width: 600px;
}
</style>
