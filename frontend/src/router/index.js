import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import SignupView from '@/views/SignupView.vue'
import QuestionsListView from '@/views/QuestionsListView.vue'
import DashboardView from '@/views/DashboardView.vue'
import ChangePasswordView from '@/views/dashboard-views/ChangePasswordView.vue'
import CreateQuestionView from '@/views/question-views/CreateQuestionView.vue'
import EditQuestionView from '@/views/question-views/EditQuestionView.vue'
import QuestionView from '@/views/QuestionView.vue'
import QuestionDetailsView from '@/views/question-views/QuestionDetailsView.vue'
import UserProfileView from '@/views/dashboard-views/UserProfileView.vue'
import UsersListView from '@/views/dashboard-views/UsersListView.vue'
import UserEditView from '@/views/dashboard-views/UserEditView.vue'

import { useUserStore } from '@/stores/user'
import ResultsView from '@/views/ResultsView.vue'

const userAccess = (to, from, next) => {
  const userStore = useUserStore()
  if (userStore.isLoggedIn()) next()
  else next('/')
}

const adminAccess = (to, from, next) => {
  const userStore = useUserStore()
  if (userStore.isLoggedIn() && userStore.user.admin) next()
  else next('/')
}

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/:code',
      name: 'question',
      component: QuestionView
    },
    {
      path: '/results/:code',
      name: 'results',
      component: ResultsView
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
      component: QuestionsListView,
      beforeEnter: userAccess,
      children: [
        {
          path: '/questions/:code',
          component: QuestionDetailsView
        },
        {
          path: '/questions/create',
          component: CreateQuestionView
        },
        {
          path: '/questions/edit/:code',
          component: EditQuestionView
        }
      ]
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: DashboardView,
      beforeEnter: userAccess,
      children: [
        {
          path: 'change-password',
          component: ChangePasswordView
        },
        {
          path: 'profile',
          component: UserProfileView
        },
        {
          path: 'users',
          component: UsersListView,
          beforeEnter: adminAccess
        },
        {
          path: 'users/:id',
          component: UserEditView,
          beforeEnter: adminAccess
        }
      ]
    }
  ]
})

export default router
