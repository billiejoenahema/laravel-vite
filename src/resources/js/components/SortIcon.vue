<script setup>
import { computed } from 'vue';
const props = defineProps({
  isAsc: {
    type: Boolean,
    required: false,
    default: '',
  },
  activeSortKey: {
    type: String,
    required: false,
    default: '',
  },
  label: {
    type: String,
    required: false,
    default: '',
  },
});
const icon = computed(() => {
  if (props.activeSortKey !== props.label) {
    return 'sort';
  }
  if (props.isAsc) {
    return 'sort-up';
  } else {
    return 'sort-down';
  }
});
</script>

<template>
  <font-awesome-icon class="sort-direction" :icon="icon" />
</template>

<style scoped>
.sort-direction {
  cursor: pointer;
}
</style>
