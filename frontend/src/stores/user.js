import router from '@/router'
import { defineStore } from 'pinia'
import { useStorage } from '@vueuse/core'
import http from '@/http'

export const useUserStore = defineStore('user', () => {
  const user = useStorage('user', {})

  const login = async (userData) => {
    const res = await http.post('/account/login', {
      email: userData.email,
      password: userData.password
    })

    if (res.status == 200) {
      user.value = {
        token: res.data.jwt,
        email: res.data.user.email,
        name: res.data.user.name,
        surname: res.data.user.surname,
        admin: res.data.user.admin == 1
      }
      router.push('/')
    } else {
      console.error(res)
      return false
    }
  }

  const logout = () => {
    user.value = {}
    router.push('/login')
  }

  const register = async (userData) => {
    const res = await http
      .post('/account/register', {
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

  const isLoggedIn = () => {
    return !(Object.keys(user.value).length === 0)
  }

  const changePassword = async (oldPass, newPass) => {
    if (!user.value.token) return

    const res = await http
      .put(
        '/account/password',
        {
          old_password: oldPass,
          new_password: newPass
        },
        {
          headers: {
            Authorization: `Bearer ${user.value.token}`
          }
        }
      )
      .catch((err) => {
        return err.response
      })

    return res
  }

  const checkExpiration = () => {
    if (isLoggedIn())
      http
        .get('/account', { headers: { Authorization: `Bearer ${user.value.token}` } })
        .then(() => {})
        .catch((err) => {
          if (err.response.status == 401) {
            logout()
          }
        })
  }

  return { user, login, logout, register, isLoggedIn, changePassword, checkExpiration }
})
