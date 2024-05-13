<template>
  <main>
    <div class="text-center">
      <div class="mb-8">
        <v-icon name="fa-regular-user-circle" scale="4"></v-icon>
      </div>
      <div class="grid grid-cols-2 gap-x-2 text-start">
        <p class="uppercase">Name:</p>
        <p class="font-bold">{{ userStore.user.name }}</p>
        <p class="uppercase">Surname:</p>
        <p class="font-bold">{{ userStore.user.surname }}</p>
        <p class="uppercase">E-mail:</p>
        <p class="font-bold">{{ userStore.user.email }}</p>
        <p class="uppercase">Role:</p>
        <p class="font-bold">
          {{
            userStore.user.admin
              ? langStore.t('admin', 'administrátor')
              : langStore.t('user', 'používateľ')
          }}
        </p>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'

const userStore = useUserStore()
const langStore = useLanguageStore()
</script>
