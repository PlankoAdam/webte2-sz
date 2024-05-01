<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useLanguageStore } from '@/stores/language'

const langStore = useLanguageStore()
</script>

<template>
  <nav class="h-16 w-full bg-slate-950 fixed top-0 left-0 text-2xl px-16">
    <div class="grid grid-cols-2 border-b-2 border-slate-700 px-8 h-full content-center">
      <div>
        <RouterLink class="text-slate-300 hover:text-slate-50 transition-all" to="/"
          >Home</RouterLink
        >
      </div>
      <div class="text-end">
        <h1
          @click="langStore.change"
          class="text-slate-300 hover:text-slate-50 transition-all cursor-pointer uppercase"
        >
          {{ langStore.t('sk', 'en') }}
        </h1>
      </div>
    </div>
  </nav>

  <div class="mt-16">
    <RouterView />
  </div>
</template>
