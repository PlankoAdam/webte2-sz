<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center">
      <div class="mb-16">
        <h1 class="text-9xl text-center font-light text-[var(--color-heading)] mb-4 select-none">
          interact<span
            class="text-[var(--acc500)] dark:text-[var(--acc400)] hover:drop-shadow-[0_0_10px_var(--acc400)] dark:hover:drop-shadow-[0_0_10px_var(--acc500)] transition-all duration-700"
            >ED</span
          >
        </h1>
        <h2 class="text-2xl text-center italic">
          {{ langStore.t('Where every student has a voice', 'Kde má každý študent svoj hlas') }}
        </h2>
      </div>
      <FormKit
        type="form"
        submit-label="Enter"
        :actions="false"
        #default="{ state: { valid } }"
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
        <FormKit
          :label="langStore.t('Enter', 'Vstúpiť')"
          type="submit"
          :disabled="!valid"
          input-class="m-0"
        />
      </FormKit>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()
</script>
