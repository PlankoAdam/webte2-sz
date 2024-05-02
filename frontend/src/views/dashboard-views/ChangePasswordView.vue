<template>
  <main class="flex justify-center">
    <div>
      <FormKit type="form" :actions="false" #default="{ state: { valid } }">
        <FormKit
          :label="langStore.t('Current password', 'Aktuálne heslo')"
          type="password"
          validation="required"
        ></FormKit>
        <FormKit
          :label="langStore.t('New password', 'Nové heslo')"
          type="password"
          validation="required"
        ></FormKit>
        <FormKit
          :label="langStore.t('Confirm new password', 'Potvrdenie nového hesla')"
          type="password"
          validation="required"
        ></FormKit>
        <FormKit
          :label="langStore.t('Change password', 'Zmeniť heslo')"
          type="submit"
          :disabled="!valid"
        />
      </FormKit>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()
</script>
