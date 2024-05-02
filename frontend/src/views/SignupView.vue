<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">
        {{ langStore.t('sign up', 'registrácia') }}
      </h1>
      <div class="mb-8">
        <FormKit
          type="form"
          :submit-label="langStore.t('Sign up', 'Zaregistrovať')"
          :actions="false"
          #default="{ state: { valid } }"
        >
          <FormKit
            type="email"
            :label="langStore.t('E-mail', 'E-mail')"
            validation="required|email"
          ></FormKit>
          <FormKit
            type="text"
            :label="langStore.t('User name', 'Používateľské meno')"
            validation="required|length:4,16"
          ></FormKit>
          <FormKit
            name="password"
            type="password"
            :label="langStore.t('Password', 'Heslo')"
            validation="required|length:8"
          ></FormKit>
          <FormKit
            name="password_confirm"
            type="password"
            :label="langStore.t('Confirm password', 'Potvrdiť heslo')"
            validation="required|confirm"
          ></FormKit>
          <FormKit label="Sign up" type="submit" :disabled="!valid" />
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
