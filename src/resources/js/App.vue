<script setup>
import Navbar from '@/views/Navbar.vue';
</script>

<template>
  <main>
    <Navbar />
    <div class="container-md">
      <router-view />
    </div>
  </main>
</template>
