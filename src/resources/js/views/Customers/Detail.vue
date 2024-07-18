<script setup>
import BaseModal from "@/components/BaseModal.vue";
import InputPostalCode from "@/components/InputPostalCode.vue";
import InputSelect from "@/components/InputSelect.vue";
import InputSelectPrefecture from "@/components/InputSelectPrefecture.vue";
import InputTel from "@/components/InputTel.vue";
import InputText from "@/components/InputText.vue";
import InputTextarea from "@/components/InputTextarea.vue";
import InvalidFeedback from "@/components/InvalidFeedback.vue";
import router from "@/router";
import { store } from "@/store";
import { formatDate } from "@/utils/formatter.js";
import { computed, onMounted, onUnmounted, reactive, ref } from "vue";
import YubinBango from "yubinbango-core2";

const initialCustomer = {
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
  note: null,
  created_at: null,
  updated_at: null,
};
const customer = reactive({
  ...initialCustomer,
});
const customerId = router.currentRoute.value?.params?.id;
const isAdmin = computed(() => store.getters["profile/isAdmin"]);
const genderFormOptions = ref([]);
const hasErrors = computed(() => store.getters["customer/hasErrors"]);
const invalidFeedback = computed(
  () => store.getters["customer/invalidFeedback"]
);
const avatarUrl = computed(() => store.getters["customer/avatarUrl"]);
const loading = computed(() => store.getters["loading/loading"]);
const isInvalid = computed(() => store.getters["customer/isInvalid"]);
const modalShow = ref(false);
const inputFileRef = ref(null);
const maxUploadSize = computed(() => store.getters["consts/maxUploadSize"]);
const isFileSizeOver = ref(false);
const inputFile = ref(null);
const avatarTrashShow = ref(false);

onMounted(async () => {
  await fetchData();
  Object.assign(
    genderFormOptions.value,
    store.getters["consts/genderFormOptions"]
  );
});
onUnmounted(() => {
  store.commit("customer/setErrors", {});
  store.commit("customer/setData", {});
  URL.revokeObjectURL(inputFile.value);
});

// 顧客情報取得
const fetchData = async () => {
  await store.dispatch("customer/get", customerId);
  Object.assign(customer, store.getters["customer/data"]);
};

// ユーザーアイコン画像操作
const fileUrl = () => {
  if (!inputFile.value) return null;
  return URL.createObjectURL(inputFile.value) ?? "";
};
// ファイル選択
const changeFile = (e) => {
  inputFile.value = e.target.files[0];
  store.commit("customer/setErrors", {});
  isFileSizeOver.value = false;
  // ファイルサイズが大きすぎる場合はエラーメッセージを表示させてボタンを無効化する
  if (inputFile.value?.size > maxUploadSize.value) {
    store.commit("customer/setErrors", {
      avatar: ["10MB以下のファイルを選択してください。"],
    });
    isFileSizeOver.value = true;
    return;
  }
};
// アイコン画像更新
const updateAvatar = async () => {
  await store.dispatch("customer/updateAvatar", {
    id: customerId,
    file: inputFile.value,
  });
  if (hasErrors.value) return;
  inputFile.value = null;
  inputFileRef.value.value = null;
  fetchData();
};
// アイコン画像削除
const deleteAvatar = async () => {
  if (!confirm("アイコンを削除しますか？")) return;
  await store.dispatch("customer/deleteAvatar", customerId);
  if (hasErrors.value) return;
  inputFile.value = null;
  inputFileRef.value.value = null;
  fetchData();
};

// 郵便番号の入力値を判定
const onBlur = (inputValue) => {
  const regex = /\d{7}/;
  // 入力値が空または7桁の数字ならエラー表示を消す
  if (inputValue === "" || inputValue.match(regex)) {
    store.commit("customer/setErrors", {});
  }
  // 7桁の数字でなければエラーを表示する
  else {
    store.commit("customer/setErrors", {
      postal_code: ["郵便番号は7桁の半角数字で入力してください。"],
    });
  }
};
// 住所を自動入力
const setAddress = (code) => {
  // エラーメッセージを初期化
  store.commit("customer/setErrors", {});
  // 入力値が空なら処理を終了する
  if (code === "") {
    store.commit("customer/setErrors", {
      postal_code: ["郵便番号を入力してください。"],
    });
    return;
  }
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
        postal_code: [
          "該当する住所が見つかりませんでした。正しい郵便番号を入力してください。",
        ],
      });
    }
    customer.pref = address.region_id; // Number 都道府県コード
    customer.city = address.locality;
    customer.street = address.street;
  });
};

// 顧客情報更新
const update = async () => {
  store.commit("customer/setErrors", {});
  await store.dispatch("customer/patch", customer);
  if (hasErrors.value) return;
  fetchData();
};
// 顧客情報削除
const deleteCustomer = async () => {
  if (!confirm("本当に顧客情報を削除してもよろしいですか？")) return;
  await store.dispatch("customer/delete", customerId);
  if (hasErrors.value) return;
  Object.assign(customer, { ...initialCustomer });
};
</script>

<template>
  <div class="mb-3">
    <router-link to="/customers">一覧に戻る</router-link>
  </div>
  <h2>顧客情報詳細</h2>
  <form v-if="customer.id" class="customer-form">
    <div>
      <div class="row mb-3">
        <div class="avatar-container m-auto d-flex align-items-start">
          <div
            @mouseover="avatarTrashShow = true"
            @mouseleave="avatarTrashShow = false"
          >
            <img
              :src="avatarUrl(customer.avatar)"
              class="avatar-thumbnail"
              loading="lazy"
              @click="modalShow = true"
            />
            <font-awesome-icon
              class="edit-icon btn p-0 text-primary"
              icon="edit"
              title="アイコンを変更"
              @click="modalShow = true"
            ></font-awesome-icon>
            <font-awesome-icon
              v-if="avatarTrashShow && isAdmin && customer.avatar"
              class="trash-icon btn p-0 text-danger"
              icon="trash"
              title="アイコンを削除"
              @click="deleteAvatar"
            ></font-awesome-icon>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerId" class="col-form-label">顧客ID</label>
        </div>
        <div class="col-10">
          <div id="customerId" class="form-control border-0">
            {{ customer.id }}
          </div>
        </div>
      </div>
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
          <label for="customerAge" class="col-form-label">年齢</label>
        </div>
        <div class="col-10">
          <div id="customerAge" class="form-control border-0">
            {{ customer.age }}<span>&nbsp;歳</span>
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerGender" class="col-form-label">性別</label>
        </div>
        <div class="col-5">
          <InputSelect
            id="customerGender"
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
            @blur="onBlur(customer.postal_code)"
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
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerId" class="col-form-label">登録日</label>
        </div>
        <div class="col-10">
          <div id="customerId" class="form-control border-0">
            {{ formatDate(customer.created_at) }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-2">
          <label for="customerId" class="col-form-label">更新日</label>
        </div>
        <div class="col-10">
          <div id="customerId" class="form-control border-0">
            {{ formatDate(customer.updated_at) }}
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-between mb-3">
      <button
        class="btn btn-primary"
        type="button"
        title="顧客情報を更新"
        @click.prevent="update"
      >
        更新
      </button>
      <button
        v-if="isAdmin"
        class="btn btn-danger"
        type="button"
        title="顧客情報を削除"
        @click.prevent="deleteCustomer"
      >
        削除
      </button>
    </div>
  </form>
  <div v-if="!customer.id && !loading">データが存在しません。</div>
  <BaseModal
    id="thumbnailModal"
    :class-value="modalShow === true ? 'show' : ''"
    title="ユーザーアイコン画像"
    button-value="保存する"
    :disabled="!inputFile || isFileSizeOver"
    @cancel="modalShow = false"
    @submit="updateAvatar"
  >
    <div class="d-flex justify-content-center">
      <img
        :src="fileUrl() ?? avatarUrl(customer.avatar)"
        class="avatar-preview rounded-circle mb-3"
      />
    </div>
    <input
      :class="isInvalid('avatar')"
      type="file"
      ref="inputFileRef"
      accept="image/*"
      @change="changeFile"
    />
    <InvalidFeedback :invalid-feedback="invalidFeedback('avatar')" />
  </BaseModal>
</template>

<style scoped>
.avatar-container {
  position: relative;
}
.edit-icon {
  position: absolute;
  left: 100px;
  top: 88px;
}
.trash-icon {
  position: absolute;
  left: 100px;
  top: 0;
}
</style>
