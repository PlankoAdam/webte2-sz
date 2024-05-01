<script setup>
import { FormKit } from '@formkit/vue'
// import { useLanguageStore } from '@/stores/language'
// const langStore = useLanguageStore()
</script>

<template>
  <main>
    <FormKit type="form" submit-label="Enter">
      <FormKit label="Question code" type="text"></FormKit>
    </FormKit>
  </main>
</template>
