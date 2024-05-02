import router from '@/router'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'

export const useUserStore = defineStore('user', () => {
  const user = useStorage('user', {})

  const login = (userData) => {
    // user login demo

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
