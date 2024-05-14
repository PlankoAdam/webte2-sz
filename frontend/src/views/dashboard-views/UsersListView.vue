<template>
  <main>
    <table class="table table-auto">
      <thead>
        <tr
          class="dark:bg-[var(--color-bg-mute)] bg-[var(--prim700)] dark:text-[var(--color-heading)] text-[var(--prim100)]"
        >
          <td>{{ ls.t('Edit', 'Upraviť') }}</td>
          <td>{{ ls.t('Name', 'Meno') }}</td>
          <td>{{ ls.t('Surname', 'Priezvisko') }}</td>
          <td>E-mail</td>
          <td>{{ ls.t('Role', 'Rola') }}</td>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users"
          :key="user.id"
          class="even:bg-[var(--color-bg-soft)] odd:bg-[var(--color-bg)]"
        >
          <td>
            <div class="flex flex-row space-x-2">
              <v-icon
                class="hover:text-[var(--color-bad)] transition-all cursor-pointer"
                name="fa-trash"
                @click="deleteUser(user.id)"
              />
              <v-icon
                class="hover:text-[var(--color-heading)] transition-all cursor-pointer"
                name="fa-edit"
                @click="$router.push(`/dashboard/users/${user.id}`)"
              />
            </div>
          </td>
          <td>{{ user.name }}</td>
          <td>{{ user.surname }}</td>
          <td>{{ user.email }}</td>
          <td>
            {{ user.admin ? ls.t('admin', 'administrátor') : ls.t('user', 'používateľ') }}
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
import { useUserStore } from '@/stores/user'

const ls = useLanguageStore()
const userStore = useUserStore()
const users = ref([])

const getUsers = () => {
  http
    .get('/users', {
      headers: {
        Authorization: `Bearer ${userStore.user.token}`
      }
    })
    .then((res) => (users.value = res.data))
}

getUsers()

const deleteUser = (id) => {
  http
    .delete(`/users/${id}`, { headers: { Authorization: `Bearer ${userStore.user.token}` } })
    .then(getUsers)
    .catch((err) => console.error(err))
}
</script>

<style scoped>
td {
  @apply p-2;
}
</style>
