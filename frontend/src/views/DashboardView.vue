<template>
  <main class="flex justify-center">
    <div class="grid grid-cols-[1fr,2fr]">
      <div class="border-e-2 border-[var(--color-bg-mute)] min-h-96 content-center">
        <div class="flex flex-col me-4 justify-end text-end space-y-4">
          <RouterLink
            to="/dashboard/profile"
            class="text-lg lg:text-xl cursor-pointer hover:text-[var(--color-heading)] transition-all"
            >{{ langStore.t('My profile', 'Môj profil') }}</RouterLink
          >
          <RouterLink
            to="/dashboard/change-password"
            class="text-lg lg:text-xl cursor-pointer hover:text-[var(--color-heading)] transition-all"
            >{{ langStore.t('Change password', 'Zmeniť heslo') }}</RouterLink
          >
        </div>
      </div>
      <div class="ms-2 lg:ms-8 content-center">
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
