<template>
  <QRModal v-if="showQRmodal" @close="showQRmodal = false"></QRModal>
  <div class="list-item">
    <div class="min-w-24 min-h-24 p-2 bg-[var(--color-bg)] rounded-lg content-center text-center">
      <div @click="showQRmodal = true" class="size-full bg-red-500 rounded-md cursor-pointer"></div>
    </div>
    <div class="flex flex-col justify-end">
      <span class="text-3xl text-[var(--color-heading)] mb-4">Lorem ipsum dolor sit?</span>
      <div class="flex flex-row space-x-4">
        <a href="" class="hover:text-[var(--color-heading)] transition-all">Edit</a>
        <a href="" class="hover:text-[var(--color-heading)] transition-all">Activate</a>
        <a href="" class="hover:text-[var(--color-heading)] transition-all">Show</a>
      </div>
    </div>
  </div>
</template>

<script setup>
// import { useLanguageStore } from '@/stores/language'
// const langStore = useLanguageStore()

import { ref } from 'vue'
import QRModal from './QRModal.vue'

const showQRmodal = ref(false)
</script>

<style scoped>
.list-item {
  background-color: var(--color-bg-mute);
  @apply flex flex-row space-x-8 rounded-lg w-[32rem] p-4;
}
</style>
