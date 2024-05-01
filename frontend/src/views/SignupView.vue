<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <h1 class="mb-8 text-2xl font-light uppercase">Sign up</h1>
      <div class="mb-8">
        <FormKit type="form" action="">
          <FormKit type="email" label="E-mail"></FormKit>
          <FormKit type="text" label="User name"></FormKit>
          <FormKit type="password" label="Password"></FormKit>
          <FormKit type="password" label="Confirm password"></FormKit>
        </FormKit>
      </div>
      <div class="text-sm text-center">
        <span class="text-slate-500 me-2">Already have an account?</span>
        <RouterLink to="/login" class="hover:text-[var(--color-heading)] transition-all"
          >Log in</RouterLink
        >
      </div>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
</script>
