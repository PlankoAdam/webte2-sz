<template>
  <QRModal
    v-if="showQRmodal"
    @close="showQRmodal = false"
    :qrsrc="props.qrsrc"
    :code="props.code"
  ></QRModal>
  <div class="list-item">
    <div
      class="min-w-24 min-h-24 max-w-24 max-h-24 p-2 bg-[var(--color-bg)] rounded-lg content-center text-center"
    >
      <img
        @click="showQRmodal = true"
        :src="props.qrsrc"
        alt="QR"
        class="size-full rounded-md cursor-pointer"
      />
    </div>
    <div class="flex flex-col justify-center">
      <span class="text-3xl font-light text-[var(--color-heading)]">{{ props.question }} </span>
      <div class="text-lg mb-2 flex flex-row space-x-2">
        <div>Code:</div>
        <div class="text-[var(--color-heading)] font-mono">{{ props.code }}</div>
      </div>
      <div class="flex flex-row space-x-4">
        <p href="" class="hover:text-[var(--color-heading)] transition-all cursor-pointer">Edit</p>
        <p href="" class="hover:text-[var(--color-heading)] transition-all cursor-pointer">
          Activate
        </p>
        <p href="" class="hover:text-[var(--color-heading)] transition-all cursor-pointer">Show</p>
      </div>
    </div>
  </div>
</template>

<script setup>
// import { useLanguageStore } from '@/stores/language'
// const langStore = useLanguageStore()

import { ref } from 'vue'
import QRModal from './QRModal.vue'

const props = defineProps({
  code: String,
  question: String,
  qrsrc: String,
  active: Boolean
})

const showQRmodal = ref(false)
</script>

<style scoped>
.list-item {
  background-color: var(--color-bg-mute);
  @apply flex flex-row space-x-8 rounded-lg w-[32rem] p-4;
}
</style>
