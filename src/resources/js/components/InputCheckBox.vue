<!-- インラインバージョン -->
<script setup>
import { computed } from 'vue';

const props = defineProps({
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
    default: false,
    required: false,
    type: Boolean,
  },
});
const emit = defineEmits(['update:modelValue']);
const model = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value),
});
</script>

<template>
  <div class="form-check form-check-inline">
    <input
      class="form-check-input"
      :class="classValue"
      :id="id"
      type="checkbox"
      v-model="model"
    />
  </div>
  <small class="form-text">{{ helperText }}</small>
  <div class="invalid-feedback">
    {{ invalidFeedback }}
  </div>
</template>
