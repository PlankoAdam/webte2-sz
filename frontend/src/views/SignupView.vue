<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">
        {{ langStore.t('sign up', 'registrácia') }}
      </h1>
      <div class="mb-8">
        <FormKit type="form" :submit-label="langStore.t('Sign up', 'Zaregistrovať')">
          <FormKit type="email" :label="langStore.t('E-mail', 'E-mail')"></FormKit>
          <FormKit type="text" :label="langStore.t('User name', 'Používateľské meno')"></FormKit>
          <FormKit type="password" :label="langStore.t('Password', 'Heslo')"></FormKit>
          <FormKit
            type="password"
            :label="langStore.t('Confirm password', 'Potvrdiť heslo')"
          ></FormKit>
        </FormKit>
      </div>
      <div class="text-sm text-center">
        <span class="text-slate-500 me-2">{{
          langStore.t('Already have an account?', 'Už máte konto?')
        }}</span>
        <RouterLink to="/login" class="hover:text-[var(--color-heading)] transition-all">{{
          langStore.t('Log in', 'Prihláste sa')
        }}</RouterLink>
      </div>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
import { useLanguageStore } from '@/stores/language'

const langStore = useLanguageStore()
</script>
