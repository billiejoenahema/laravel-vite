<script setup>
import Toast from '@/components/Toast.vue';
import Navbar from '@/views/Navbar.vue';
</script>

<template>
  <main>
    <Navbar />
    <Toast />
    <div class="container-md">
      <router-view />
    </div>
  </main>
</template>
