<template>
  <main class="flex justify-center">
    <FormKit type="form" @submit="submitHandler" :actions="false" #default="{ state: { valid } }">
      <FormKit
        name="email"
        label="E-mail"
        v-model="data.email"
        validation="required|email"
      ></FormKit>
      <FormKit
        name="name"
        :label="ls.t('Name', 'Meno')"
        v-model="data.name"
        validation="required"
      ></FormKit>
      <FormKit
        name="surname"
        :label="ls.t('Surname', 'Priezvisko')"
        v-model="data.surname"
        validation="required"
      ></FormKit>
      <FormKit
        name="admin"
        :label="ls.t('Role', 'Rola')"
        v-model="data.admin"
        type="select"
        :options="[
          { label: ls.t('Admin', 'Administrátor'), value: 1 },
          { label: ls.t('User', 'Používateľ'), value: 0 }
        ]"
      ></FormKit>
      <FormKit label="Save" type="submit" :disabled="!valid" />
    </FormKit>
  </main>
</template>

<script setup>
import http from '@/http'
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { useLanguageStore } from '@/stores/language'
import { ref } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const userStore = useUserStore()
const ls = useLanguageStore()

const data = ref({})

const getData = () => {
  http
    .get(`/users/${route.params.id}`, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then((res) => {
      data.value = res.data
    })
    .catch((err) => console.error(err))
}

const submitHandler = (formData) => {
  http
    .put(`/users/${route.params.id}`, formData, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then(() => router.push('/users'))
    .catch((err) => console.error(err))
}

getData()
</script>
