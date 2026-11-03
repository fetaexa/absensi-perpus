<script setup>
import { ref } from 'vue'
import { RouterView, useRouter } from 'vue-router'

const router = useRouter()
const transitionName = ref('no-transition')

router.beforeEach((to, from) => {
  if (from.path === '/login' && to.path === '/home') {
    transitionName.value = 'page-zoom'
  } else {
    transitionName.value = 'no-transition'
  }
})
</script>

<template>
  <!-- <RouterView /> -->
  <RouterView v-slot="{ Component, route }">
    <Transition :name="transitionName" mode="out-in">
      <component :is="Component" :key="route.matched[0]?.path ?? route.path" class="bg-3 w-100 h-100" />
    </Transition>
  </RouterView>
</template>

<style>
.page-zoom-enter-active,
.page-zoom-leave-active {
  transition: transform 0.35s ease, opacity 0.35s ease;
  transform-origin: center center;
}

.page-zoom-enter-from {
  transform: scale(.85);
  opacity: 0;
}

.page-zoom-leave-to {
  transform: scale(1.1);
  opacity: 0;
}

.no-transition-enter-active,
.no-transition-leave-active {
  transition: none;
}
</style>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

body {
  background: white;
}

main {
  overflow-y: auto;
  overflow-x: hidden;

}

html::-webkit-scrollbar,
body::-webkit-scrollbar {
  display: none;
}
</style>