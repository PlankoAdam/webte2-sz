<template>
  <div
    class="flex flex-row space-x-8 rounded-lg w-full h-24 p-4 bg-[var(--prim400)] dark:bg-[var(--prim700)] transition-all hover:cursor-pointer hover:scale-[103%] ease-out duration-100"
    :class="{
      'opacity-50': !props.active
    }"
  >
    <div class="flex flex-col justify-center">
      <span>{{ props.subject }} </span>
      <span class="text-3xl font-light">{{ props.question }} </span>
      <div class="text-lg mb-2 flex flex-row space-x-2">
        <div class="">
          {{ langStore.t('Code', 'Kód') }}
        </div>
        <div class="font-mono font-bold">
          {{ props.code }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()

// import { ref } from 'vue'

const props = defineProps({
  code: String,
  question: String,
  subject: String,
  qrsrc: String,
  active: Boolean
})

// const showQRmodal = ref(false)
</script>
