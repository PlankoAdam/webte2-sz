<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-background-soft)] p-8 rounded-xl">
      <div class="mb-8">
        <FormKit type="form" action="">
          <FormKit type="email" label="E-mail"></FormKit>
          <FormKit type="text" label="User name"></FormKit>
          <FormKit type="password" label="Password"></FormKit>
          <FormKit type="password" label="Confirm password"></FormKit>
        </FormKit>
      </div>
      <div class="text-sm">
        <span>Already have an account?</span>
        <RouterLink to="/login">Log in</RouterLink>
      </div>
    </div>
  </main>
</template>

<script setup>
import { FormKit } from '@formkit/vue'
</script>
