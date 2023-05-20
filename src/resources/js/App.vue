<script setup>
import CircleDotLoader from '@/components/CircleDotLoader.vue';
import Overlay from '@/components/Overlay.vue';
import Navbar from '@/views/Navbar.vue';
import { computed } from 'vue';
import { store } from './store';

const loading = computed(() => store.getters['loading/loading']);
const data = computed(() => store.getters['overlay/data']);
</script>

<template>
  <main>
    <Navbar />
    <Overlay :data="data" />
    <CircleDotLoader :loading="loading" />
    <div class="container-md">
      <router-view />
    </div>
  </main>
</template>
