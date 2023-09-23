<script setup>
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
const emit = defineEmits(['update:modelValue', 'blur']);
const updateModelValue = (e) => {
  emit('update:modelValue', e.target.value);
};
const onBlur = () => {
  emit('blur')
}

</script>

<template>
  <div class="input-wrapper">
      <input
        :aria-describedby="`${id}HelpBlock`"
        autocorrect="postal-code"
        :autocomplete="autocomplete"
        class="form-control"
        :class="classValue"
        :disabled="disabled"
        :id="id"
        inputmode="numeric"
        maxlength="8"
        :placeholder="placeholder"
        type="text"
        :value="modelValue"
        @input="updateModelValue"
        @blur="onBlur"
      />
    <div class="form-text-wrapper">
      <div :id="`${id}HelpBlock`" class="form-text text-muted">
        {{ helperText }}
      </div>
    </div>
    <div class="invalid-feedback">
      {{ invalidFeedback }}
    </div>
  </div>
</template>

<style scoped>
.input-wrapper {
  position: relative;
}
.form-text-wrapper {
  display: flex;
  justify-content: space-between;
}
</style>
