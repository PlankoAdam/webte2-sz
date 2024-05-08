import router from '@/router'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import http from '@/http'

export const useUserStore = defineStore('user', () => {
  const user = useStorage('user', {})

  const login = async (userData) => {
    // user login demo
    const res = await http.post('/user/login')

    if (res.status == 200) {
      user.value = {
        email: userData.email, // TODO
        admin: false // TODO
      }
      router.push('/')
    } else {
      console.error(res)
      return false
    }
  }

  const logout = () => {
    user.value = null
    router.push('/')
  }

  const register = async (userData) => {
    const res = await http
      .post('/user/register', {
        email: userData.email,
        name: userData.name,
        surname: userData.surname,
        password: userData.password
      })
      .catch((err) => {
        return err.response
      })

    return res.status
  }

  return { user, login, logout, register }
})
