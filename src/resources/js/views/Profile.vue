<script setup>
import InputText from "@/components/InputText.vue";
import { store } from "@/store";
import { formatDate } from "@/utils/formatter.js";
import { computed, onMounted, onUnmounted, reactive } from "vue";

const initialProfile = {
  id: null,
  name: null,
  email: null,
  role: null,
  role_value: null,
  last_login_at: null,
};
const profile = reactive({
  ...initialProfile,
});
const hasErrors = computed(() => store.getters["profile/hasErrors"]);
const invalidFeedback = computed(
  () => store.getters["profile/invalidFeedback"]
);
const loading = computed(() => store.getters["loading/loading"]);
const isInvalid = computed(() => store.getters["profile/isInvalid"]);

onMounted(async () => {
  await fetchData();
});
onUnmounted(() => {
  store.commit("profile/setErrors", {});
  store.commit("profile/setData", {});
});

// 顧客情報取得
const fetchData = async () => {
  await store.dispatch("profile/get");
  Object.assign(profile, store.getters["profile/data"]);
};

// 顧客情報更新
const update = async () => {
  store.commit("profile/setErrors", {});
  await store.dispatch("profile/patch", profile);
  if (hasErrors.value) return;
  fetchData();
};
</script>

<template>
  <div class="mb-3">
    <router-link to="/">TOPに戻る</router-link>
  </div>
  <h2>プロフィール</h2>
  <form v-if="profile.id" class="profile-form">
    <div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="profileId" class="col-form-label">ユーザーID</label>
        </div>
        <div class="col-9">
          <div id="profileId" class="form-control border-0">
            {{ profile.id }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="profileName" class="col-form-label">ユーザー名</label>
        </div>
        <div class="col-9">
          <InputText
            id="profileName"
            :class-value="isInvalid('name')"
            :invalid-feedback="invalidFeedback('name')"
            input-counter="on"
            :maxlength="50"
            v-model="profile.name"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="profileName" class="col-form-label">メールアドレス</label>
        </div>
        <div class="col-9">
          <InputText
            id="profileEmail"
            :class-value="isInvalid('email')"
            :invalid-feedback="invalidFeedback('email')"
            input-counter="on"
            :maxlength="255"
            v-model="profile.email"
          />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="profileRole" class="col-form-label">権限</label>
        </div>
        <div class="col-9">
          <div id="profileRole" class="form-control border-0">
            {{ profile.role_value }}
          </div>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-3">
          <label for="profileLastLoginAt" class="col-form-label"
            >最終ログイン日時</label
          >
        </div>
        <div class="col-9">
          <div id="profileLastLoginAt" class="form-control border-0">
            {{ formatDate(profile.last_login_at) }}
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
    </div>
  </form>
  <div v-if="!profile.id && !loading">データが存在しません。</div>
</template>
