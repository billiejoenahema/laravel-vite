<script setup>
import { computed, ref } from 'vue';
const props = defineProps({
  autocomplete: {
    default: 'on',
    required: false,
    type: [String],
    validator(value) {
      return ['on', 'off'].includes(value);
    },
  },
  classValue: {
    default: '',
    required: false,
    type: String,
  },
  disabled: {
    default: false,
    required: false,
    type: Boolean,
  },
  helperText: {
    default: '',
    required: false,
    type: String,
  },
  id: {
    default: '',
    required: true,
    type: String,
  },
  invalidFeedback: {
    default: '',
    required: false,
    type: String,
  },
  modelValue: {
    default: '',
    required: false,
    type: [String, Number],
  },
  placeholder: {
    default: '',
    required: false,
    type: String,
  },
});
const inputCorrectness = ref('');
const regex = /\d{7}/;
const emit = defineEmits(['update:modelValue', 'search']);
const updateModelValue = (e) => {
  emit('update:modelValue', e.target.value);
};
const search = () => {
  if (regex.test(props.modelValue)) {
    inputCorrectness.value = '';
  }
  emit('search', props.modelValue);
};
const inputClassName = computed(() => {
  return `${props.classValue}`;
});
// 7桁の半角数字かどうかを判定する
const determineInputValue = () => {
  if (props.modelValue === '') {
    inputCorrectness.value = '';
    return;
  }
  inputCorrectness.value = regex.test(props.modelValue)
    ? 'is-valid'
    : 'is-invalid';
};
</script>

<template>
  <div class="input-wrapper">
    <form @submit.prevent="search" class="input-area">
      <input
        :aria-describedby="`${id}HelpBlock`"
        autocorrect="postal-code"
        :autocomplete="autocomplete"
        class="form-control border-dark me-2"
        :class="inputClassName + inputCorrectness"
        :disabled="disabled"
        :id="id"
        inputmode="numeric"
        maxlength="8"
        :placeholder="placeholder"
        type="text"
        :value="modelValue"
        @input="updateModelValue"
        @blur="determineInputValue"
      />
      <button class="address-search-button" type="button" @click="search">
        住所を検索
      </button>
    </form>
    <div class="form-text-wrapper">
      <div :id="`${id}HelpBlock`" class="form-text text-muted">
        {{ helperText }}
      </div>
    </div>
    <div class="invalid-feedback">
      <div v-if="inputCorrectness === 'is-invalid' && !invalidFeedback">
        7桁の半角数字で入力してください。
      </div>
      {{ invalidFeedback }}
    </div>
  </div>
</template>

<style scoped>
.input-wrapper {
  position: relative;
}
.input-area {
  display: flex;
  flex-direction: row;
}
.input-area > input {
  margin-right: 2rem;
}
.address-search-button {
  white-space: nowrap;
}
.form-text-wrapper {
  display: flex;
  justify-content: space-between;
}
</style>
