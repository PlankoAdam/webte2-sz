<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">{{ langStore.t('log in', 'prihlásenie') }}</h1>
      <div class="mb-8">
        <FormKit type="form" :submit-label="langStore.t('Log in', 'Prihlásiť sa')">
          <FormKit type="text" :label="langStore.t('User name', 'Používateľské meno')"></FormKit>
          <FormKit type="password" :label="langStore.t('Password', 'Heslo')"></FormKit>
        </FormKit>
      </div>
      <div class="text-sm text-center">
        <span class="text-slate-500 me-2">{{
          langStore.t(`Don't have an account?`, 'Nemáte konto?')
        }}</span>
        <RouterLink to="/signup" class="hover:text-[var(--color-heading)] transition-all">{{
          langStore.t('Sign up', 'Zaregistrujte sa')
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
