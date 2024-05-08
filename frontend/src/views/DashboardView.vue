<template>
  <main class="flex justify-center">
    <div class="grid grid-cols-2">
      <div class="border-e-2 border-[var(--color-text)] min-h-48 content-center">
        <div class="flex flex-col me-4 justify-end text-end space-y-4">
          <RouterLink
            to="/dashboard/profile"
            class="text-xl cursor-pointer hover:text-[var(--color-heading)] transition-all"
            >{{ langStore.t('My profile', 'Môj profil') }}</RouterLink
          >
          <RouterLink
            to="/dashboard/change-password"
            class="text-xl cursor-pointer hover:text-[var(--color-heading)] transition-all"
            >{{ langStore.t('Change password', 'Zmeniť heslo') }}</RouterLink
          >
        </div>
      </div>
      <div class="ms-8">
        <RouterView></RouterView>
      </div>
    </div>
  </main>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()
</script>
