<template>
  <main class="flex justify-center">
    <div class="bg-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">
        {{ langStore.t('sign up', 'registrácia') }}
      </h1>
      <div class="mb-8">
        <FormKit
          type="form"
          :submit-label="langStore.t('Sign up', 'Zaregistrovať')"
          @submit="signUp"
          :actions="false"
          #default="{ state: { valid } }"
        >
          <FormKit
            name="email"
            type="email"
            :label="langStore.t('E-mail', 'E-mail')"
            validation="required|email"
          ></FormKit>
          <FormKit
            name="name"
            type="text"
            :label="langStore.t('First name', 'Meno')"
            validation="required"
          ></FormKit>
          <FormKit
            name="surname"
            type="text"
            :label="langStore.t('Last name', 'Priezvisko')"
            validation="required"
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
        <RouterLink to="/login" class="font-bold hover:text-[var(--sec500)] transition-all">{{
          langStore.t('Log in', 'Prihláste sa')
        }}</RouterLink>
      </div>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'
import router from '@/router'

const langStore = useLanguageStore()
const userStore = useUserStore()

const signUp = async (formData, node) => {
  const statusCode = await userStore.register(formData)
  console.log(statusCode)

  if (statusCode == 400) {
    node.setErrors([], {
      email: 'That email is already registered'
    })
  } else if (statusCode == 201) {
    router.push('/login')
  } else {
    console.error(statusCode)
  }
}
</script>
