import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUserStore = defineStore('user', () => {
  const user = ref(null)

  const login = (userName) => {
    // user login demo
    user.value = {
      userName,
      admin: false
    }
  }

  const logout = () => {
    user.value = null
  }

  return { user, login, logout }
})
