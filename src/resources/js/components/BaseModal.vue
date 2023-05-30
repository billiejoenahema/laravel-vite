<script setup>
defineProps({
  id: {
    type: String,
    required: true,
    default: 'example',
  },
  classValue: {
    type: String,
    required: false,
    default: '',
  },
  title: {
    type: String,
    required: false,
    default: '',
  },
  buttonValue: {
    type: String,
    required: false,
    default: '',
  },
});
const emit = defineEmits(['submit', 'cancel']);
const close = () => {
  emit('cancel');
};
const submit = () => {
  close();
  emit('submit');
};
</script>

<template>
  <div
    :class="'modal ' + classValue"
    :id="id"
    tabindex="-1"
    :aria-labelledby="id + 'ModalLabel'"
    @click.self="close"
  >
    <div class="modal-dialog">
      <div class="modal-content modal-dialog-centered">
        <div class="modal-header">
          <h5 class="modal-title" :id="id + 'ModalLabel'">{{ title }}</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="close"
          ></button>
        </div>
        <div class="modal-body">
          <slot></slot>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
            @click="close"
          >
            キャンセル
          </button>
          <button type="button" class="btn btn-primary" @click="submit">
            {{ buttonValue }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.show {
  display: block !important;
}
</style>
