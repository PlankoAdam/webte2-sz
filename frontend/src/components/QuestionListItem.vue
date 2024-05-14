<template>
  <div
    class="flex flex-row space-x-8 rounded-lg w-full h-24 p-2 px-4 bg-[var(--prim100)] dark:bg-[var(--prim700)] transition-all hover:cursor-pointer hover:scale-[103%] ease-out duration-100"
    :class="{
      'opacity-50': !props.active
    }"
  >
    <div class="flex flex-col justify-center lg:min-w-96 lg:max-w-96 w-full">
      <p
        class="text-2xl font-light text-ellipsis overflow-clip whitespace-nowrap lg:w-full max-w-96"
      >
        {{ props.question }}
      </p>
      <span>{{ props.subject }} </span>
      <div class="flex flex-row justify-between mb-2 text-md">
        <div class="flex flex-row space-x-2">
          <div>
            {{ langStore.t('Code', 'Kód') }}
          </div>
          <div class="font-mono font-bold">
            {{ props.code }}
          </div>
        </div>
        <p v-if="props.user">{{ props.user }}</p>
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
  user: String,
  qrsrc: String,
  active: Boolean
})

// const showQRmodal = ref(false)
</script>
