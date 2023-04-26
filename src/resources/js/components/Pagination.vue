<script setup>
const props = defineProps({
  links: {
    type: Array,
    required: false,
    default: () => [],
  },
});
const emit = defineEmits(['change']);
const changePage = (url = null) => {
  if (!url) return;
  const page = url.substring(url.indexOf('=') + 1);
  emit('change', page);
};
const linkLabel = (label) => {
  return label.replace('&laquo; 前', '<<').replace('次 &raquo;', '>>');
};
</script>

<template>
  <nav class="pagination-nav" aria-label="...">
    <ul class="pagination">
      <li
        v-for="link in links"
        class="page-item"
        :class="{
          disabled: link.url === null,
          active: link.active,
        }"
        :tabindex="link.url === null ? '-1' : ''"
        @click.prevent="changePage(link.url)"
      >
        <a href="#" class="page-link">
          <code>{{ linkLabel(link.label) }}</code>
        </a>
      </li>
    </ul>
  </nav>
</template>

<style>
.pagination-nav {
  display: flex;
  justify-content: center;
}
.page-link {
  user-select: none;
}
</style>
