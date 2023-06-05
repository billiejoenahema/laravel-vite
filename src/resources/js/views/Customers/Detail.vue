<script setup>
import BaseModal from '@/components/BaseModal.vue';
import InputSelect from '@/components/InputSelect.vue';
import InputSelectPrefecture from '@/components/InputSelectPrefecture.vue';
import InputTel from '@/components/InputTel.vue';
import InputText from '@/components/InputText.vue';
import { formatDate } from '@/utils/formatter.js';
import { computed, onMounted, onUnmounted, reactive, ref } from 'vue';
import router from '../../router';
import { store } from '../../store';

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
const customerId = router.currentRoute.value?.params?.id;
const genderFormOptions = ref([]);
const hasErrors = computed(() => store.getters['customer/hasErrors']);
const invalidFeedback = computed(
  () => store.getters['customer/invalidFeedback']
);
const isInvalid = computed(() => store.getters['customer/isInvalid']);
const modalShow = ref(false);
const inputFileRef = ref(null);
onMounted(async () => {
  await store.dispatch('customer/get', customerId);
  Object.assign(customer, store.getters['customer/data']);
  Object.assign(
    genderFormOptions.value,
    store.getters['consts/genderFormOptions']
  );
});
onUnmounted(() => {
  store.commit('customer/setErrors', {});
  URL.revokeObjectURL(inputFile.value);
});

// ユーザーアイコン画像操作
const inputFile = ref(null);
const fileUrl = () => {
  if (!inputFile.value) return null;
  return URL.createObjectURL(inputFile.value) ?? '';
};
// ファイル選択
const changeFile = (e) => {
  inputFile.value = e.target.files[0];
};
// アイコン画像更新
const updateAvatar = async () => {
  await store.dispatch('customer/updateAvatar', {
    id: customerId,
    file: inputFile.value,
  });
  if (hasErrors.value) return;
  inputFile.value = null;
  inputFileRef.value.value = null;
  await store.dispatch('customer/get', customerId);
  Object.assign(customer, store.getters['customer/data']);
};

// 顧客情報更新
const update = async () => {
  await store.dispatch('customer/patch', customer);
  if (hasErrors) return;
  Object.assign(customer, store.getters['customer/data']);
};
</script>

<template>
  <div class="mb-3">
    <router-link to="/customers">一覧に戻る</router-link>
  </div>
  <form>
    <div class="customer-detail">
      <div class="row align-items-center mb-3">
        <div class="avatar-container">
          <img
            :src="customer.avatar"
            class="avatar-thumbnail"
            @click="modalShow = true"
          />
          <font-awesome-icon
            class="edit-icon btn p-0 text-primary"
            icon="edit"
            @click="modalShow = true"
          ></font-awesome-icon>
        </div>
      </div>
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
          <InputText
            id="customerName"
            :class-value="isInvalid('name')"
            :invalid-feedback="invalidFeedback('name')"
            input-counter="on"
            :maxlength="50"
            v-model="customer.name"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerNameKana" class="col-form-label">ふりがな</label>
        </div>
        <div class="col-8">
          <InputText
            id="customerNameKana"
            :class-value="isInvalid('name_kana')"
            :invalid-feedback="invalidFeedback('name_kana')"
            input-counter="on"
            :maxlength="50"
            v-model="customer.name_kana"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerAge" class="col-form-label">年齢</label>
        </div>
        <div class="col-8">
          <div id="customerAge" class="form-control border-0">
            {{ customer.age }}
          </div>
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerGender" class="col-form-label">性別</label>
        </div>
        <div class="col-3">
          <InputSelect
            id="customerGender"
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
          <InputTel
            id="customerPhone"
            :class-value="isInvalid('phone')"
            :invalid-feedback="invalidFeedback('phone')"
            type="tel"
            autocomplete="on"
            maxlength="15"
            v-model="customer.phone"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerBirthDate" class="col-form-label">生年月日</label>
        </div>
        <div class="col-8">
          <InputText
            id="customerBirthDate"
            :class-value="isInvalid('birth_date')"
            :invalid-feedback="invalidFeedback('birth_date')"
            type="date"
            v-model="customer.birth_date"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerPostalCode" class="col-form-label"
            >郵便番号</label
          >
        </div>
        <div class="col-3">
          <InputText
            id="customerPostalCode"
            :class-value="isInvalid('postal_code')"
            :invalid-feedback="invalidFeedback('postal_code')"
            v-model="customer.postal_code"
          />
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
          <InputText
            id="customerCity"
            :class-value="isInvalid('city')"
            :invalid-feedback="invalidFeedback('city')"
            v-model="customer.city"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerStreet" class="col-form-label">番地</label>
        </div>
        <div class="col-8">
          <InputText
            id="customerStreet"
            :class-value="isInvalid('street')"
            :invalid-feedback="invalidFeedback('street')"
            v-model="customer.street"
          />
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerId" class="col-form-label">登録日</label>
        </div>
        <div class="col-8">
          <div id="customerId" class="form-control border-0">
            {{ formatDate(customer.created_at) }}
          </div>
        </div>
      </div>
      <div class="row align-items-center mb-3">
        <div class="col-2">
          <label for="customerId" class="col-form-label">更新日</label>
        </div>
        <div class="col-8">
          <div id="customerId" class="form-control border-0">
            {{ formatDate(customer.updated_at) }}
          </div>
        </div>
      </div>
    </div>
    <button class="btn btn-primary" type="button" @click.prevent="update">
      更新
    </button>
  </form>
  <BaseModal
    id="thumbnailModal"
    :class-value="modalShow === true ? 'show' : ''"
    title="ユーザーアイコン画像"
    button-value="保存する"
    :disabled="!inputFile"
    @cancel="modalShow = false"
    @submit="updateAvatar"
  >
    <div class="d-flex justify-content-center">
      <img
        :src="fileUrl() ?? customer.avatar"
        class="avatar-preview rounded-circle mb-3"
      />
    </div>
    <input
      type="file"
      ref="inputFileRef"
      accept="image/*"
      @change="changeFile"
    />
  </BaseModal>
</template>

<style scoped>
.customer-detail {
  max-width: 600px;
}
.avatar-container {
  position: relative;
}
.edit-icon {
  position: absolute;
  left: 100px;
  top: 88px;
}
</style>
