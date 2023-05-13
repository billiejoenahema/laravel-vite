<script setup>
import InputSelect from "@/components/InputSelect.vue";
import InputSelectPrefecture from "@/components/InputSelectPrefecture.vue";
import InputText from "@/components/InputText.vue";
import { onMounted, reactive } from "vue";
import router from "../../router";
import { store } from "../../store";

const customer = reactive({
  id: null,
  name: null,
  name_kana: null,
  age: null,
  gender: null,
  phone: null,
  birth_date: null,
  postal_code: null,
  pref: null,
  city: null,
  street: null,
  created_at: null,
  updated_at: null,
});
const genderFormOptions = [];
const customerId = router.currentRoute.value?.params?.id;
onMounted(async () => {
  await store.dispatch("customer/get", customerId);
  Object.assign(customer, store.getters["customer/data"]);
  genderFormOptions.push(...store.getters["consts/genderFormOptions"]);
});
</script>

<template>
  <router-link to="/customers">一覧に戻る</router-link>
  <div class="customer-detail">
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerId" class="col-form-label">顧客ID</label>
      </div>
      <div class="col-8">
        <div id="customerId" class="form-control border-0">
          {{ customer.id }}
        </div>
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerName" class="col-form-label">氏名</label>
      </div>
      <div class="col-8">
        <InputText id="customerName" v-model="customer.name" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerNameKana" class="col-form-label">ふりがな</label>
      </div>
      <div class="col-8">
        <InputText id="customerNameKana" v-model="customer.name_kana" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerAge" class="col-form-label">年齢</label>
      </div>
      <div class="col-2">
        <InputText id="customerAge" v-model="customer.age" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerAge" class="col-form-label">性別</label>
      </div>
      <div class="col-3">
        <InputSelect
          id="customerAge"
          :options="genderFormOptions"
          v-model="customer.gender"
        />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerPhone" class="col-form-label">電話番号</label>
      </div>
      <div class="col-8">
        <InputText id="customerPhone" type="tel" v-model="customer.phone" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerBirthDate" class="col-form-label">生年月日</label>
      </div>
      <div class="col-8">
        <InputText
          id="customerBirthDate"
          type="date"
          v-model="customer.birth_date"
        />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerPostalCode" class="col-form-label">郵便番号</label>
      </div>
      <div class="col-3">
        <InputText id="customerPostalCode" v-model="customer.postal_code" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerPref" class="col-form-label">都道府県</label>
      </div>
      <div class="col-3">
        <InputSelectPrefecture id="customerPref" v-model="customer.pref" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerCity" class="col-form-label">市区町村</label>
      </div>
      <div class="col-8">
        <InputText id="customerCity" v-model="customer.city" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerStreet" class="col-form-label">番地</label>
      </div>
      <div class="col-8">
        <InputText id="customerStreet" v-model="customer.street" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerCreatedAt" class="col-form-label">登録日</label>
      </div>
      <div class="col-8">
        <InputText id="customerCreatedAt" v-model="customer.created_at" />
      </div>
    </div>
    <div class="row align-items-center mb-3">
      <div class="col-2">
        <label for="customerUpdatedAt" class="col-form-label">更新日</label>
      </div>
      <div class="col-8">
        <InputText id="customerUpdatedAt" v-model="customer.updated_at" />
      </div>
    </div>
  </div>
</template>

<style scoped>
.customer-detail {
  max-width: 600px;
}
</style>
