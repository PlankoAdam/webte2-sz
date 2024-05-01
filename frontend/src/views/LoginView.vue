<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <div class="mb-8">
        <FormKit type="form" action="">
          <FormKit type="text" label="User name"></FormKit>
          <FormKit type="password" label="Password"></FormKit>
        </FormKit>
      </div>
      <div class="text-sm">
        <span class="text-slate-500 me-2">Don't have an account?</span>
        <RouterLink to="/signup" class="hover:text-[var(--color-heading)] transition-all"
          >Sign up</RouterLink
        >
      </div>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
</script>
