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
  inputtingPlaceholder: {
    default: 'off',
    required: false,
    type: String,
    validator(value) {
      return ['on', 'off'].includes(value);
    },
  },
  invalidFeedback: {
    default: '',
    required: false,
    type: String,
  },
  maxlength: {
    default: null,
    required: false,
    type: [String, Number],
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
const emit = defineEmits(['update:modelValue']);
const updateModelValue = (e) => {
  emit('update:modelValue', e.target.value);
};
const inputClassName = computed(() => {
  return props.inputtingPlaceholder === 'on'
    ? `${props.classValue} ${inputCorrectness.value} show-inputting-placeholder`
    : `${props.classValue} ${inputCorrectness.value}`;
});
const showInputtingPlaceholder = computed(
  () => props.inputtingPlaceholder === 'on' && props.modelValue
);
// 正しい入力値かどうかを判定する
//   半角数字のみ許可 /^[0-9]+$/g
//   数字のみ許可 /^[０-９0-9]+$/g
//   数字とハイフンのみ許可 /^[０-９0-9-－ー−―‐ｰ—₋]+$/g
const determineInputValue = (e) => {
  if (e.target.value === '') {
    inputCorrectness.value = '';
    return;
  }
  const regex = /^[０-９0-9-－ー−―‐ｰ—₋]+$/g;
  inputCorrectness.value = regex.test(e.target.value) ? '' : 'is-invalid';
};
</script>

<template>
  <div class="input-wrapper">
    <input
      :aria-describedby="`${id}HelpBlock`"
      :autocomplete="autocomplete"
      class="form-control"
      :class="inputClassName"
      :disabled="disabled"
      :id="id"
      inputmode="tel"
      :maxlength="maxlength"
      :placeholder="placeholder"
      type="tel"
      :value="modelValue"
      @input="updateModelValue"
      @blur="determineInputValue"
    />
    <div
      v-if="showInputtingPlaceholder"
      class="inputting-placeholder text-muted"
    >
      {{ placeholder }}
    </div>
    <div class="invalid-feedback">
      <div v-if="inputCorrectness === 'is-invalid' && !invalidFeedback">
        数字とハイフンのみで入力してください。
      </div>
      {{ invalidFeedback }}
    </div>
    <div :id="`${id}HelpBlock`" class="form-text text-muted">
      {{ helperText }}
    </div>
  </div>
</template>

<style scoped>
.input-wrapper {
  position: relative;
}
.inputting-placeholder {
  position: absolute;
  top: 0;
  left: 8px;
  font-size: 0.5rem;
}
.form-text-wrapper {
  display: flex;
  justify-content: space-between;
}
</style>
