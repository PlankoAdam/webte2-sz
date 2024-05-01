<template>
  <div class="list-item">
    <div class="min-w-24 min-h-24 p-2 bg-[var(--color-bg)] rounded-lg content-center text-center">
      <div class="size-full bg-red-500 rounded-md"></div>
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
</script>

<style scoped>
.list-item {
  background-color: var(--color-bg-mute);
  @apply flex flex-row space-x-8 rounded-lg w-[32rem] p-4;
}
</style>
