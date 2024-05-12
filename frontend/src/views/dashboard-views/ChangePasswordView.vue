<template>
  <main class="flex justify-center">
    <div>
      <FormKit type="form" @submit="formHandler" :actions="false" #default="{ state: { valid } }">
        <FormKit
          name="old_pass"
          :label="langStore.t('Current password', 'Aktuálne heslo')"
          type="password"
          validation="required"
        ></FormKit>
        <FormKit
          name="new_pass"
          :label="langStore.t('New password', 'Nové heslo')"
          type="password"
          validation="required|length:8"
        ></FormKit>
        <FormKit
          name="new_pass_confirm"
          :label="langStore.t('Confirm new password', 'Potvrdenie nového hesla')"
          type="password"
          validation="required|confirm"
          validation-visibility="live"
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
import router from '@/router'
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'

const langStore = useLanguageStore()
const userStore = useUserStore()

const formHandler = async (formData, node) => {
  const res = await userStore.changePassword(formData.old_pass, formData.new_pass)

  if (res.status == 200) {
    router.push('/dashboard/profile')
  } else {
    node.setErrors([], {
      old_pass: 'Wrong password!'
    })
  }
}
</script>
