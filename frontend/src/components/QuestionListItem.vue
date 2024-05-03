<template>
  <div
    class="flex flex-row space-x-8 rounded-lg w-full h-24 p-4 text-[var(--prim400)] dark:text-[var(--prim500)] transition-all"
    :class="{
      active: props.active,
      'bg-[var(--color-bg-soft)]': !props.active
    }"
  >
    <div class="flex flex-col justify-center">
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
  qrsrc: String,
  active: Boolean
})

// const showQRmodal = ref(false)
</script>

<style scoped>
.active {
  @apply text-[var(--prim950)] dark:text-[var(--prim050)];

  background-image: linear-gradient(180deg, var(--prim300), var(--prim400) 51%, var(--prim400));
  @media (prefers-color-scheme: dark) {
    color: var(--prim050);
    background-image: linear-gradient(180deg, var(--prim600), var(--prim700) 51%, var(--prim700));
  }
  background-position: 0 var(--y, 100%);
  background-size: 200% 200%;
}

.active:hover {
  @apply cursor-pointer;
  --y: 0;
}

.active p {
  @apply text-[var(--prim950)] hover:bg-[var(--prim500)];
  @apply dark:text-[var(--prim050)] dark:hover:bg-[var(--prim500)];
}

div p {
  @apply px-2 rounded-md;
}

.activate-btn {
  @apply text-[var(--prim950)] hover:bg-[var(--prim400)];
  @apply dark:text-[var(--prim050)] dark:hover:bg-[var(--prim600)];
}
</style>
