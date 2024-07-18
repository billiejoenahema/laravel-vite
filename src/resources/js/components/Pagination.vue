<script setup>
const props = defineProps({
  links: {
    type: Array,
    required: false,
    default: () => [],
  },
});
const emit = defineEmits(["change"]);
const changePage = (url = null) => {
  if (!url) return;
  const page = url.substring(url.indexOf("=") + 1);
  emit("change", page);
};
const linkLabel = (label) => {
  return label.replace("&laquo;", "«").replace("&raquo;", "»");
};
</script>

<template>
  <nav class="navigation" aria-label="...">
    <ul class="pagination justify-content-center">
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
        <a href="#" class="page-link"> {{ linkLabel(link.label) }} </a>
      </li>
    </ul>
  </nav>
</template>

<style>
.page-link {
  user-select: none;
}
</style>
