<script setup>
defineProps({
  invalidFeedback: {
    type: String,
    default: '',
  },
});
</script>

<template>
  <div class="invalid-feedback">
    {{ invalidFeedback }}
  </div>
</template>
