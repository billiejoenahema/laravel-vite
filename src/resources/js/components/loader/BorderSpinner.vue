<script setup>
defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
});
const r = 252;
const g = 163;
const b = 90;
</script>

<template>
  <div class="overlay" v-if="loading">
    <div class="loader"></div>
  </div>
</template>

<style scoped>
.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 10000;
}
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(v-bind(r), v-bind(g), v-bind(b), 0.2);
  border-right: 1.1em solid rgba(v-bind(r), v-bind(g), v-bind(b), 0.2);
  border-bottom: 1.1em solid rgba(v-bind(r), v-bind(g), v-bind(b), 0.2);
  border-left: 1.1em solid rgb(v-bind(r), v-bind(g), v-bind(b));
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
