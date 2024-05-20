<template>
  <main class="flex justify-center">
    <div
      class="grid grid-rows-[8rem,1fr] lg:grid-cols-[1fr,2fr] min-h-[80vh] lg:min-h-80 min-w-[95vw] lg:min-w-0"
    >
      <div
        class="lg:border-e-2 lg:border-[var(--color-bg-mute)] max-h-fit lg:min-h-80 content-center"
      >
        <div class="flex flex-col me-4 lg:justify-end lg:text-end space-y-4">
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
