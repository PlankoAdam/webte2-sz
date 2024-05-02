<script setup>
import { FormKit } from '@formkit/vue'
import { useLanguageStore } from '@/stores/language'

const langStore = useLanguageStore()
</script>

<template>
  <main>
    <FormKit
      type="form"
      submit-label="Enter"
      @submit="
        (formData) => {
          $router.push(`/${formData.code}`)
        }
      "
    >
      <FormKit
        name="code"
        :label="langStore.t('Question code', 'Kód otázky')"
        type="text"
        validation="required|length:5,5"
      ></FormKit>
    </FormKit>
  </main>
</template>
