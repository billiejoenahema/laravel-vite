<script setup>
import { computed } from "vue";
import { store } from "../store";

const toast = computed(() => store.getters["toast/data"]);
const bgColor = () => {
  if (toast.value.status < 300) {
    return "bg-success";
  } else if (toast.value.status >= 400) {
    return "bg-danger";
  } else {
    return "";
  }
};
const close = () => store.commit("toast/setData", {});
</script>

<template>
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
    <div
      v-show="toast.content"
      id="liveToast"
      class="toast hide"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
    >
      <div
        :class="
          'toast-body d-flex flex-row justify-content-between ' + bgColor()
        "
      >
        <div>{{ toast.content }}</div>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="toast"
          aria-label="Close"
          @click="close"
        ></button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.toast:not(.show) {
  display: block;
}
</style>
