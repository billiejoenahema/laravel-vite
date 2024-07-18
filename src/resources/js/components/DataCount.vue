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
  <div>
    {{ meta.from + "-" + meta.to + " of " + meta.total }}
  </div>
</template>
