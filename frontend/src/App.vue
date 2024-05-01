<template>
  <nav class="h-20 w-full fixed top-0 left-0 px-16">
    <div class="grid grid-cols-2 h-full content-center">
      <div class="flex flex-row text-3xl space-x-8">
        <RouterLink
          to="/"
          class="inline-block hover:text-[var(--color-heading)] hover:-translate-y-1 hover:drop-shadow-[0_0_10px_var(--color-text)] transition-all"
          >{{ langStore.t('Home', 'Domov') }}</RouterLink
        >
        <RouterLink
          v-if="userStore.user"
          to="/questions"
          class="inline-block hover:text-[var(--color-heading)] hover:-translate-y-1 hover:drop-shadow-[0_0_10px_var(--color-text)] transition-all"
          >{{ langStore.t('Questions', 'Otázky') }}</RouterLink
        >
      </div>
      <div class="flex flex-row justify-end space-x-6 items-center">
        <RouterLink
          v-if="!userStore.user"
          to="/login"
          class="inline-block uppercase hover:text-[var(--color-heading)] hover:drop-shadow-[0_0_5px_var(--color-text)] transition-all"
          >{{ langStore.t('log in', 'prihlásenie') }}</RouterLink
        >
        <h1
          v-if="userStore.user"
          @click="userStore.logout"
          class="min-w-8 text-center cursor-pointer uppercase hover:text-[var(--color-heading)] hover:drop-shadow-[0_0_5px_var(--color-text)] transition-all"
        >
          {{ langStore.t('log out', 'odhlásiť sa') }}
        </h1>
        <h1
          @click="langStore.change"
          class="min-w-8 text-center cursor-pointer uppercase hover:text-[var(--color-heading)] hover:drop-shadow-[0_0_5px_var(--color-text)] transition-all"
        >
          {{ langStore.t('sk', 'en') }}
        </h1>
      </div>
    </div>
  </nav>

  <div class="mt-20">
    <RouterView />
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'

const langStore = useLanguageStore()
const userStore = useUserStore()
</script>

<style scoped>
nav {
  border-bottom: 2px solid;
  border-image: linear-gradient(to right, rgba(0, 0, 0, 0), var(--color-border), rgba(0, 0, 0, 0))
    30;
}
</style>
