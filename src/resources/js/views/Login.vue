<script setup>
import InputText from '@/components/InputText.vue';
import { computed, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

const router = useRouter();
const store = useStore();

const user = reactive({
  email: '',
  password: '',
});
const hasErrors = computed(() => store.getters['auth/hasErrors']);
const isForgotPassword = ref(false);

const login = async () => {
  await store.dispatch('auth/login', user);
  if (!hasErrors.value) {
    router.push('/');
  }
};
const forgotPassword = async () => {
  await store.dispatch('auth/forgotPassword', { email: user.email });
};
</script>

<template>
  <div class="login-form">
    <form class="column">
      <div class="invalid-feedback" v-if="hasErrors">
        メールアドレスまたはパスワードに誤りがあります。
      </div>
      <p class="column">
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
      </p>
      <template v-if="!isForgotPassword">
        <p class="column">
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
          <button class="sign-in" @click.prevent.stop="login()">
            ログイン
          </button>
        </p>
        <div class="d-flex justify-content-between align-items-center">
          <a href="#" @click.prevent.stop="isForgotPassword = true"
            >パスワードを忘れた方はこちら</a
          >
        </div>
      </template>
      <template v-else>
        <div class="d-flex justify-content-between align-items-center">
          <button @click.prevent="forgotPassword()">パスワードを再設定</button>
          <a href="#" @click.prevent="isForgotPassword = false"
            >ログイン画面に戻る</a
          >
        </div>
      </template>
    </form>
  </div>
</template>
