<script setup>
import { computed } from "vue";
const props = defineProps({
  autocomplete: {
    default: "on",
    required: false,
    type: [String],
    validator(value) {
      return ["on", "off"].includes(value);
    },
  },
  autocorrect: {
    default: "off",
    required: false,
    type: [String],
    validator(value) {
      return [
        "address-level1",
        "address-level2",
        "address-line1",
        "address-line2",
        "email",
        "family-name",
        "given-name",
        "name",
        "off",
        "organization",
        "postal-code",
      ].includes(value);
    },
  },
  classValue: {
    default: "",
    required: false,
    type: String,
  },
  disabled: {
    default: false,
    required: false,
    type: Boolean,
  },
  helperText: {
    default: "",
    required: false,
    type: String,
  },
  id: {
    default: "",
    required: true,
    type: String,
  },
  // 入力文字数カウント表示/非表示
  inputCounter: {
    default: "off",
    required: false,
    type: String,
    validator(value) {
      return ["on", "off"].includes(value);
    },
  },
  inputmode: {
    default: "text",
    required: false,
    type: [String],
    validator(value) {
      return [
        "decimal",
        "email",
        "numeric",
        "search",
        "tel",
        "text",
        "url",
      ].includes(value);
    },
  },
  // 入力中のプレースホルダー表示/非表示
  inputtingPlaceholder: {
    default: "off",
    required: false,
    type: String,
    validator(value) {
      return ["on", "off"].includes(value);
    },
  },
  invalidFeedback: {
    default: "",
    required: false,
    type: String,
  },
  maxlength: {
    default: null,
    required: false,
    type: [String, Number],
  },
  modelValue: {
    default: "",
    required: false,
    type: [String, Number],
  },
  placeholder: {
    default: "",
    required: false,
    type: String,
  },
  rows: {
    default: 4,
    required: false,
    type: [String, Number],
  },
  type: {
    default: "text",
    required: false,
    validator(value) {
      return [
        "date",
        "datetime-local",
        "email",
        "month",
        "password",
        "search",
        "text",
        "tel",
        "time",
        "url",
      ].includes(value);
    },
  },
});
const emit = defineEmits(["update:modelValue"]);
const updateModelValue = (event) => {
  emit("update:modelValue", event.target.value);
};
const showInputCounter = computed(
  () => props.inputCounter === "on" && props.maxlength
);
const showInputtingPlaceholder = computed(
  () => props.inputtingPlaceholder === "on" && props.modelValue
);
const textMuted = computed(() =>
  props.modelValue?.length === 0 ? "text-muted" : ""
);
</script>

<template>
  <div class="input-wrapper">
    <textarea
      :aria-describedby="`${id}HelpBlock`"
      :autocomplete="autocomplete"
      :autocorrect="autocorrect"
      class="form-control"
      :class="classValue"
      :disabled="disabled"
      :id="id"
      :inputmode="inputmode"
      :maxlength="maxlength"
      :placeholder="placeholder"
      :rows="rows"
      :type="type"
      :value="modelValue"
      @input="updateModelValue"
    />
    <div
      v-if="showInputtingPlaceholder"
      class="inputting-placeholder text-muted"
    >
      {{ placeholder }}
    </div>
    <div class="invalid-feedback">
      {{ invalidFeedback }}
    </div>
    <div class="form-text-wrapper">
      <div :id="`${id}HelpBlock`" class="form-text text-muted">
        {{ helperText }}
      </div>
      <div v-if="showInputCounter" :class="'form-text ' + textMuted">
        {{ modelValue?.length ?? 0 }}/{{ maxlength }}
      </div>
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
