<script setup>
import InputText from "@/components/InputText.vue";
import router from "@/router";
import { store } from "@/store";
import { computed, reactive, ref } from "vue";

const user = reactive({
  email: "",
  password: "",
});
const hasErrors = computed(() => store.getters["auth/hasErrors"]);
const isForgotPassword = ref(false);

const login = async () => {
  store.commit("auth/setErrors", {});
  await store.dispatch("auth/login", user);
  if (!hasErrors.value) {
    router.push("/");
  }
};
const forgotPassword = async () => {
  await store.dispatch("auth/forgotPassword", { email: user.email });
};
</script>

<template>
  <div class="login-form">
    <form>
      <div class="invalid-feedback" v-if="hasErrors">
        メールアドレスまたはパスワードに誤りがあります。
      </div>
      <div class="mb-3">
        <label for="login-email">Email</label>
        <InputText
          v-model="user.email"
          id="login-email"
          name="email"
          type="email"
          maxlength="255"
          autocomplete="on"
          inputmode="email"
        />
      </div>
      <template v-if="!isForgotPassword">
        <div class="mb-3">
          <label for="login-password">Password</label>
          <InputText
            v-model="user.password"
            id="login-password"
            name="password"
            type="password"
            maxlength="128"
            autocomplete="on"
            inputmode="text"
          />
        </div>
        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary mb-3" @click.prevent.stop="login()">
            ログイン
          </button>
          <a href="#" @click.prevent.stop="isForgotPassword = true"
            >パスワードを忘れた方はこちら</a
          >
        </div>
      </template>
      <template v-else>
        <div class="d-flex justify-content-between align-items-center">
          <button class="btn btn-primary" @click.prevent="forgotPassword()">
            パスワードを再設定
          </button>
          <a href="#" @click.prevent="isForgotPassword = false"
            >ログイン画面に戻る</a
          >
        </div>
      </template>
    </form>
  </div>
</template>

<style scoped>
.login-form {
  max-width: 400px;
  margin: auto;
}
.invalid-feedback {
  display: block;
}
</style>
