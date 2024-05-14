<template>
  <main>
    <div class="text-center">
      <div class="mb-8">
        <v-icon name="fa-regular-user-circle" scale="4"></v-icon>
      </div>
      <div class="grid grid-cols-2 gap-x-2 text-start">
        <p class="uppercase">{{ ls.t('Name:', 'Meno:') }}</p>
        <p class="font-bold">{{ userStore.user.name }}</p>
        <p class="uppercase">{{ ls.t('Surname:', 'Priezvisko:') }}</p>
        <p class="font-bold">{{ userStore.user.surname }}</p>
        <p class="uppercase">E-mail:</p>
        <p class="font-bold">{{ userStore.user.email }}</p>
        <p class="uppercase">{{ ls.t('Role:', 'Rola:') }}</p>
        <p class="font-bold">
          {{ userStore.user.admin ? ls.t('admin', 'administrátor') : ls.t('user', 'používateľ') }}
        </p>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'

const userStore = useUserStore()
const ls = useLanguageStore()
</script>
