<template>
  <nav class="h-16 w-full fixed top-0 left-0 lg:px-16 px-4 bg-[var(--color-bg)] z-20">
    <div class="grid grid-cols-2 h-full content-center">
      <div class="flex flex-row text-3xl lg:space-x-8 space-x-4">
        <RouterLink
          to="/"
          class="inline-block hover:text-[var(--color-heading)] hover:-translate-y-1 hover:drop-shadow-[0_0_10px_var(--color-text)] transition-all"
          >{{ langStore.t('Home', 'Domov') }}</RouterLink
        >
        <RouterLink
          v-if="userStore.isLoggedIn()"
          to="/questions"
          class="inline-block hover:text-[var(--color-heading)] hover:-translate-y-1 hover:drop-shadow-[0_0_10px_var(--color-text)] transition-all"
          >{{ langStore.t('Questions', 'Otázky') }}</RouterLink
        >
      </div>
      <div class="flex lg:flex-row flex-col-reverse justify-end lg:space-x-6 space-x-2 items-end">
        <RouterLink
          v-if="userStore.isLoggedIn()"
          to="/dashboard/profile"
          class="min-w-8 text-center cursor-pointer uppercase hover:text-[var(--color-heading)] hover:drop-shadow-[0_0_5px_var(--color-text)] transition-all"
        >
          {{ userStore.user.name }}
        </RouterLink>
        <div class="flex flex-row space-x-4">
          <RouterLink
            v-if="!userStore.isLoggedIn()"
            to="/login"
            class="inline-block uppercase hover:text-[var(--color-heading)] hover:drop-shadow-[0_0_5px_var(--color-text)] transition-all"
            >{{ langStore.t('log in', 'prihlásenie') }}</RouterLink
          >
          <h1
            v-if="userStore.isLoggedIn()"
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
    </div>
  </nav>

  <div>
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
/* nav {
  border-bottom: 2px solid;
  border-image: linear-gradient(to right, rgba(0, 0, 0, 0), var(--color-border), rgba(0, 0, 0, 0))
    30;
} */
</style>
