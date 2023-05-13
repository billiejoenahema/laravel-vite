<script setup>
defineProps({
  meta: {
    type: Object,
    required: false,
    default: () => {},
  },
});
</script>

<template>
  <div class="px-4 mb-4">
    {{ meta.from + '-' + meta.to + ' of ' + meta.total }}
  </div>
</template>
