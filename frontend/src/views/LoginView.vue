<template>
  <main class="flex justify-center">
    <div class="bg-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">{{ langStore.t('log in', 'prihlásenie') }}</h1>
      <div class="mb-8">
        <FormKit
          type="form"
          @submit="userStore.login"
          :submit-label="langStore.t('Log in', 'Prihlásiť sa')"
          :actions="false"
          #default="{ state: { valid } }"
        >
          <FormKit name="email" type="text" validation="required" label="E-mail"></FormKit>
          <FormKit
            name="password"
            type="password"
            validation="required"
            :label="langStore.t('Password', 'Heslo')"
          ></FormKit>
          <FormKit label="Log in" type="submit" :disabled="!valid" />
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
import { useUserStore } from '@/stores/user'

const langStore = useLanguageStore()
const userStore = useUserStore()
</script>
