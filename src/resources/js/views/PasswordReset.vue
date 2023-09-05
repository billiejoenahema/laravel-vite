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
    <form @submit.prevent="submit">
      <div class="mb-3">
        <label for="email">Email</label>
        <input
          :class="isInvalid('email')"
          class="form-control"
          v-model="form.email"
          id="email"
          name="email"
          type="email"
          maxlength="255"
          @change="form.validate('email')"
        />
        <div v-if="form.invalid('email')" class="invalid-feedback">
            {{ form.errors.email }}
        </div>
      </div>
      <div class="mb-3">
        <label for="password">Password</label>
        <input
          :class="isInvalid('password')"
          class="form-control"
          v-model="form.password"
          id="password"
          name="password"
          type="password"
          maxlength="128"
          @change="form.validate('password')"
        />
        <div v-if="form.invalid('password')" class="invalid-feedback">
            {{ form.errors.password }}
        </div>
      </div>
      <div class="mb-3">
        <label for="confirm-password">Confirm Password</label>
        <input
          class="form-control"
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
      </div>
      <button class="sign-in btn btn-primary mb-3">
        Password Reset
      </button>
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
