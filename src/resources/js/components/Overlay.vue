<script setup>
const props = defineProps({
  data: {
    type: Object,
    default: () => {},
  },
});
const bgColor = () => {
  if (props.data?.status === 200) {
    return "bg-success";
  }
  if (props.data?.status === 500) {
    return "bg-danger";
  }
  return "";
};
</script>

<template>
  <div class="overlay" v-if="data.message">
    <h1>
      <span :class="'badge ' + bgColor()">{{ data.message }}</span>
    </h1>
  </div>
</template>

<style scoped>
.overlay {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 100vw;
  z-index: 10000;
}
</style>
