<template>
  <main>
    <table class="table table-auto">
      <thead>
        <tr class="bg-[var(--color-bg-mute)] text-[var(--color-heading)]">
          <td>Name</td>
          <td>Surname</td>
          <td>E-mail</td>
          <td>Role</td>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users"
          :key="user.id"
          class="even:bg-[var(--color-bg-soft)] odd:bg-[var(--color-bg)]"
        >
          <td>{{ user.name }}</td>
          <td>{{ user.surname }}</td>
          <td>{{ user.email }}</td>
          <td>
            {{
              user.admin ? langStore.t('admin', 'administrátor') : langStore.t('user', 'používateľ')
            }}
          </td>
        </tr>
      </tbody>
    </table>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import http from '@/http'
import { useLanguageStore } from '@/stores/language'

const langStore = useLanguageStore()
const users = ref([])

const getUsers = () => {
  http.get('/users').then((res) => (users.value = res.data))
}

getUsers()
</script>
