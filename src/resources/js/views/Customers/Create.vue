<script setup>
import InputPostalCode from "@/components/InputPostalCode.vue";
import InputSelect from "@/components/InputSelect.vue";
import InputSelectPrefecture from "@/components/InputSelectPrefecture.vue";
import InputTel from "@/components/InputTel.vue";
import InputText from "@/components/InputText.vue";
import InputTextarea from "@/components/InputTextarea.vue";
import router from "@/router";
import { store } from "@/store";
import { computed, onUnmounted, reactive } from "vue";
import YubinBango from "yubinbango-core2";

const customer = reactive({
  avatar: null,
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
  note: null,
});

const genderFormOptions = computed(
  () => store.getters["consts/genderFormOptions"]
);
const hasErrors = computed(() => store.getters["customer/hasErrors"]);
const invalidFeedback = computed(
  () => store.getters["customer/invalidFeedback"]
);
const isInvalid = computed(() => store.getters["customer/isInvalid"]);

// 住所を自動入力
const setAddress = (code) => {
  // エラーメッセージを初期化
  store.commit("customer/setErrors", {});
  // 入力値が空なら処理を終了する
  if (code === "") return;
  // 7桁の数字でなければエラーを表示して処理を終了する
  if (!code.match(/^\d{7}/)) {
    store.commit("customer/setErrors", {
      postal_code: ["郵便番号は7桁の半角数字で入力してください。"],
    });
    return;
  }

  // 住所をセットする
  new YubinBango.Core(code, (address) => {
    // 存在しない郵便番号だった場合はエラーメッセージを表示させる
    if (!address.region) {
      store.commit("customer/setErrors", {
        postal_code: ["該当する住所が見つかりませんでした。"],
      });
    }
    customer.pref = address.region_id; // Number 都道府県コード
    customer.city = address.locality;
    customer.street = address.street;
  });
};

const moveToIndex = () => {
  router.push("/customers");
};

// 登録
const register = async () => {
  // 顧客情報を登録する
  await store.dispatch("customer/post", customer);
  if (hasErrors.value) return;
  const registeredCustomer = store.getters["customer/data"];
  setTimeout(() => {
    router.push(`/customers/${registeredCustomer.id}`);
  }, 2000);
};

onUnmounted(() => {
  store.commit("customer/setErrors", {});
});
</script>

<template>
  <div class="mb-3">
    <router-link to="/customers">一覧に戻る</router-link>
  </div>
  <h2>顧客新規登録</h2>
  <form class="customer-form">
    <div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerName" class="col-form-label">氏名</label>
        </div>
        <div class="col-10">
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
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerNameKana" class="col-form-label">ふりがな</label>
        </div>
        <div class="col-10">
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
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerGender" class="col-form-label">性別</label>
        </div>
        <div class="col-5">
          <InputSelect
            id="customerGender"
            :class-value="isInvalid('gender')"
            :invalid-feedback="invalidFeedback('gender')"
            :options="genderFormOptions"
            v-model="customer.gender"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerPhone" class="col-form-label">電話番号</label>
        </div>
        <div class="col-10">
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
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerBirthDate" class="col-form-label">生年月日</label>
        </div>
        <div class="col-10">
          <InputText
            id="customerBirthDate"
            :class-value="isInvalid('birth_date')"
            :invalid-feedback="invalidFeedback('birth_date')"
            type="date"
            v-model="customer.birth_date"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerPostalCode" class="col-form-label"
            >郵便番号</label
          >
        </div>
        <div class="col-5">
          <InputPostalCode
            id="customerPostalCode"
            :class-value="isInvalid('postal_code')"
            :invalid-feedback="invalidFeedback('postal_code')"
            v-model="customer.postal_code"
          />
        </div>
        <div class="col-3">
          <button
            class="btn btn-secondary"
            type="button"
            @click="setAddress(customer.postal_code)"
          >
            住所を検索
          </button>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerPref" class="col-form-label">都道府県</label>
        </div>
        <div class="col-5">
          <InputSelectPrefecture id="customerPref" v-model="customer.pref" />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerCity" class="col-form-label">市区町村</label>
        </div>
        <div class="col-10">
          <InputText
            id="customerCity"
            :class-value="isInvalid('city')"
            :invalid-feedback="invalidFeedback('city')"
            v-model="customer.city"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerStreet" class="col-form-label">番地</label>
        </div>
        <div class="col-10">
          <InputText
            id="customerStreet"
            :class-value="isInvalid('street')"
            :invalid-feedback="invalidFeedback('street')"
            v-model="customer.street"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerNote" class="col-form-label">備考</label>
        </div>
        <div class="col-10">
          <InputTextarea
            id="customerNote"
            :class-value="isInvalid('note')"
            :invalid-feedback="invalidFeedback('note')"
            input-counter="on"
            :maxlength="500"
            v-model="customer.note"
          />
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
      <button
        class="btn btn-primary"
        type="button"
        title="顧客情報を登録"
        @click.prevent="register"
      >
        登録
      </button>
      <button
        class="btn btn-secondary"
        type="button"
        title="キャンセル"
        @click.prevent="moveToIndex"
      >
        キャンセル
      </button>
    </div>
  </form>
</template>
