<script setup>
const props = defineProps({
  classValue: {
    type: String,
    required: false,
    default: "",
  },
  disabled: {
    default: false,
    required: false,
    type: Boolean,
  },
  id: {
    default: "",
    required: true,
    type: String,
  },
  invalidFeedback: {
    default: "",
    required: false,
    type: String,
  },
  options: {
    default: () => [],
    required: false,
    type: Array,
  },
  modelValue: {
    default: "",
    required: false,
    type: [String, Number],
  },
});
const emit = defineEmits(["update:modelValue"]);
const updateModelValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>

<template>
  <select
    class="form-select"
    :class="classValue"
    :disabled="disabled"
    :id="id"
    :value="modelValue"
    @change="updateModelValue"
  >
    <option v-for="option in options" :value="option.id">
      {{ option.name }}
    </option>
  </select>
  <div class="invalid-feedback">{{ invalidFeedback }}</div>
</template>
