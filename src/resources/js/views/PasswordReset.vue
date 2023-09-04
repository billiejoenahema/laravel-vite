<script setup>
import router from '@/router';
import { store } from '@/store';
import { useForm } from 'laravel-precognition-vue';
import { computed, onMounted, ref } from 'vue';

const isInvalid = computed(() => store.getters['auth/isInvalid']);
const isNotMatchPassword = ref(false)
const form = useForm('post', '/api/reset-password', {
  email: null,
  password: null,
  confirm_password: null,
  token: null,
});
onMounted(() => {
  form.token = router.currentRoute.value.query.token;
});
const passwordsMatch = () => {
  isNotMatchPassword.value = form.confirm_password !== form.password;
}
const submit = async () => {
  const response = await form.submit();
  if (response.request.status !== 200) return;
  setTimeout(() => {
    router.push('/');
  }, 2000);
  };
</script>

<template>
  <div class="login-form">
    <form class="column" @submit.prevent="submit">
      <p class="column">
        <label for="email">Email</label>
        <input
          :class="isInvalid('email')"
          v-model="form.email"
          id="email"
          name="email"
          type="email"
          maxlength="255"
          @change="form.validate('email')"
        />
        <div v-if="form.invalid('email')" class="invalid-feedback d-block">
            {{ form.errors.email }}
        </div>
      </p>
      <p class="column">
        <label for="password">Password</label>
        <input
          :class="isInvalid('password')"
          v-model="form.password"
          id="password"
          name="password"
          type="password"
          maxlength="128"
          @change="form.validate('password')"
        />
        <div v-if="form.invalid('password')" class="invalid-feedback d-block">
            {{ form.errors.password }}
        </div>
      </p>
      <p class="column">
        <label for="confirm-password">Confirm Password</label>
        <input
          v-model="form.confirm_password"
          id="confirm-password"
          name="password"
          type="password"
          maxlength="128"
          @change="passwordsMatch"
        />
        <div v-if="isNotMatchPassword" class="invalid-feedback d-block">
          パスワードが一致していません
        </div>
      </p>
      <button
        class="sign-in"
        :disabled="!form.password || form.password !== form.confirm_password"
      >
        Password Reset
      </button>
    </form>
  </div>
</template>
