<script setup>
import InvalidFeedback from '@/components/InvalidFeedback.vue';
import { computed, onMounted, reactive } from 'vue';
import router from '@/router';
import { store } from '@/store';

const hasErrors = computed(() => store.getters['auth/hasErrors']);
const invalidFeedback = computed(() => store.getters['auth/invalidFeedback']);
const isInvalid = computed(() => store.getters['auth/isInvalid']);
const data = reactive({
  email: null,
  password: null,
  confirm_password: null,
  token: null,
});
onMounted(() => {
  data.token = router.currentRoute.value.query.token;
});
const resetPassword = async () => {
  if (router.currentRoute.value.query.email !== data.email) {
    store.commit('auth/setErrors', {
      email: ['メールアドレスが間違っています。'],
    });
    return;
  }
  await store.dispatch('auth/resetPassword', data);
  if (hasErrors.value) return;
  setTimeout(() => {
    router.push('/');
  }, 2000);
};
</script>

<template>
  <div class="login-form">
    <form class="column">
      <p class="column">
        <label for="email">Email</label>
        <input
          :class="isInvalid('email')"
          v-model="data.email"
          id="email"
          name="email"
          type="email"
          maxlength="255"
        />
        <InvalidFeedback
          v-if="invalidFeedback('email')"
          :errors="invalidFeedback('email')"
        />
      </p>
      <p class="column">
        <label for="password">Password</label>
        <input
          :class="isInvalid('password')"
          v-model="data.password"
          id="password"
          name="password"
          type="password"
          maxlength="128"
        />
        <InvalidFeedback
          v-if="invalidFeedback('password')"
          :errors="invalidFeedback('password')"
        />
      </p>
      <p class="column">
        <label for="confirm-password">Confirm Password</label>
        <input
          v-model="data.confirm_password"
          id="confirm-password"
          name="password"
          type="password"
          maxlength="128"
        />
      </p>
      <button
        class="sign-in"
        @click.prevent.stop="resetPassword()"
        :disabled="!data.password || data.password !== data.confirm_password"
      >
        Password Reset
      </button>
    </form>
  </div>
</template>
