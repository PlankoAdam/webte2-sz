import router from '@/router'
import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useUserStore = defineStore('user', () => {
  const user = ref(null)

  const login = (userData) => {
    // user login demo
    console.log(userData)

    user.value = {
      username: userData.username,
      admin: false
    }

    router.push('/')
  }

  const logout = () => {
    user.value = null
    router.push('/')
  }

  return { user, login, logout }
})
