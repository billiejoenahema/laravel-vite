<script setup>
import CircleDotLoader from '@/components/CircleDotLoader.vue';
import Overlay from '@/components/Overlay.vue';
import Navbar from '@/views/Navbar.vue';
import { computed } from 'vue';
import { store } from './store';

const loading = computed(() => store.getters['loading/loading']);
const message = computed(() => store.getters['overlay/data']);
</script>

<template>
  <main>
    <Navbar />
    <Overlay :message="message" />
    <CircleDotLoader :loading="loading" />
    <div class="container-md">
      <router-view />
    </div>
  </main>
</template>
