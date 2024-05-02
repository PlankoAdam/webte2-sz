import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import SignupView from '@/views/SignupView.vue'
import QuestionsView from '@/views/QuestionsView.vue'
import DashboardView from '@/views/DashboardView.vue'
import ChangePasswordView from '@/views/dashboard-views/ChangePasswordView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/signup',
      name: 'signup',
      component: SignupView
    },
    {
      path: '/questions',
      name: 'questions',
      component: QuestionsView
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      children: [
        {
          path: 'change-password',
          component: ChangePasswordView
        }
      ]
    }
  ]
})

export default router
