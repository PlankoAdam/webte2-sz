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
      children: [
        {
          path: '/questions/:id',
          component: QuestionDetailsView
        },
        {
          path: '/questions/create',
          component: CreateQuestionView
        },
        {
          path: '/questions/edit/:id',
          component: EditQuestionView
        }
      ]
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
