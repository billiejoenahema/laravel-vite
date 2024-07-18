<script setup>
import { ref } from "vue";
defineProps({
  content: {
    type: String,
    required: false,
    default: "",
  },
});

const tooltipStyle = ref("");
const tooltipShow = ref(false);
const toggleShowTooltip = (e) => {
  tooltipShow.value = !tooltipShow.value;
  setTooltipPosition(e);
};
const setTooltipPosition = (e) => {
  const elTop = e.target.getBoundingClientRect().top ?? 0;
  const elBottom = e.target.getBoundingClientRect().bottom ?? 0;
  // ウィンドウの高さ
  const windowInnerHeight = window.innerHeight ?? 100;
  // 要素がウインドウの上端に近いかどうか（基準値が適切かどうかは要検討）
  const isNearTop = elTop / windowInnerHeight < 0.1;
  if (isNearTop) {
    // 要素がウインドウの上端に近い場合は要素の下にツールチップを表示する
    tooltipStyle.value = `top: ${elBottom - elTop}px;`;
  } else {
    // そうでなければ要素の上にツールチップを表示する
    tooltipStyle.value = `bottom: ${elBottom - elTop}px;`;
  }
};
</script>

<template>
  <div
    class="tooltip-wrapper"
    @click="toggleShowTooltip"
    @mouseleave="tooltipShow = false"
  >
    <pre v-if="tooltipShow" class="tooltip-content" :style="tooltipStyle">
      {{ content }}
    </pre>
    <slot />
  </div>
</template>

<style>
.tooltip-wrapper {
  position: relative;
  cursor: pointer;
  display: flex;
  align-items: center;
}
.tooltip-wrapper p {
  margin: 0;
  padding: 0;
}
.tooltip-content {
  display: flex;
  position: absolute;
  z-index: 2000;
  padding: 0.5rem;
  font-size: 0.8rem;
  color: #f1f1f1;
  border-radius: 5px;
  background: #333;
  min-width: 240px;
  cursor: initial;
  white-space: pre-line;
}
</style>
