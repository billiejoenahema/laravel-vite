<script setup>
import Overlay from '@/components/Overlay.vue';
import CircleDotsLoader from '@/components/loader/CircleDotsLoader.vue';
import { store } from '@/store';
import Navbar from '@/views/Navbar.vue';
import { computed } from 'vue';

const loading = computed(() => store.getters['loading/loading']);
const data = computed(() => store.getters['overlay/data']);
</script>

<template>
  <main>
    <Navbar />
    <Overlay :data="data" />
    <CircleDotsLoader :loading="loading" />
    <div class="container-md">
      <router-view />
    </div>
  </main>
</template>
