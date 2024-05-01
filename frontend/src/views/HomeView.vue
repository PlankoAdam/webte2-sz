<script setup>
import { useLanguageStore } from '@/stores/language'

const langStore = useLanguageStore()
</script>

<template>
  <main>
    <h1>
      {{ langStore.t('Home page', 'Domovska stranka') }}
    </h1>
    <div class="h-48 w-48 bg-red-400"></div>
  </main>
</template>
