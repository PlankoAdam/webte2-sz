<template>
  <main class="flex lg:flex-row flex-col lg:min-w-[100vw]">
    <div
      class="p-4 mt-[var(--nav-h)] items-center lg:min-w-[28rem] min-w-[100vw] fixed top-0 bottom-0 overflow-y-scroll bg-[var(--prim300)] dark:bg-[var(--prim800)]"
    >
      <RouterLink to="/questions/create">
        <div
          class="flex flex-row justify-center items-center space-x-4 w-full h-24 p-4 transition-all cursor-pointer hover:scale-[103%] ease-out duration-100 mb-8"
        >
          <div
            class="bg-[var(--color-text)] text-[var(--prim300)] dark:text-[var(--prim800)] rounded-md"
          >
            <v-icon name="fa-plus" scale="3"></v-icon>
          </div>
          <div class="content-center text-3xl font-light">
            {{ ls.t('Create new question', 'Vytvoriť novú otázku') }}
          </div>
        </div>
      </RouterLink>

      <div class="mb-8">
        <FormKit
          type="select"
          v-model="subjectFilter"
          :label="ls.t('Subject', 'Predmet')"
          :options="
            subjects.map((el) => {
              return {
                label: el.subject,
                value: el.id
              }
            })
          "
          input-class="min-w-full max-w-full mb-2"
        ></FormKit>
        <FormKit
          v-if="userStore.user.admin"
          type="select"
          v-model="userFilter"
          :label="ls.t('User', 'Používateľ')"
          :options="
            users.map((el) => {
              return {
                label: `${el.name} ${el.surname}`,
                value: el.id
              }
            })
          "
          input-class="min-w-full max-w-full"
        ></FormKit>
      </div>

      <div class="flex flex-col space-y-4">
        <RouterLink v-for="q in filteredQuestions" :key="q.code" :to="`/questions/${q.code}`">
          <QuestionListItem
            :code="q.code"
            :question="q.question"
            :subject="q.subject"
            :user="q.user ? `${q.user.name} ${q.user.surname}` : ''"
            active
          ></QuestionListItem>
        </RouterLink>
      </div>
    </div>
    <RouterView></RouterView>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'
import QuestionListItem from '@/components/QuestionListItem.vue'
import { RouterLink } from 'vue-router'
import { ref } from 'vue'
import http from '@/http'
import { watch } from 'vue'
import { useRoute } from 'vue-router'
import { computed } from 'vue'

const route = useRoute()

const ls = useLanguageStore()
const userStore = useUserStore()

const questions = ref([])
const users = ref([])
const subjects = ref([])

const userFilter = ref()
const subjectFilter = ref()

const filteredQuestions = computed(() => {
  return questions.value.filter((el) => {
    return (
      (subjectFilter.value ? el.subject_id == subjectFilter.value : true) &&
      (userStore.user.admin && userFilter.value ? el.user_id == userFilter.value : true)
    )
  })
})

const getData = () => {
  http
    .get('/subject')
    .then((res) => {
      subjects.value = [
        {
          subject: ls.t('All', 'Všetky'),
          id: null
        }
      ]
      subjects.value.push(...res.data)
    })
    .catch((err) => console.error(err))

  if (userStore.user.admin)
    http
      .get('/users', { headers: { Authorization: `Bearer ${userStore.user.token}` } })
      .then((res) => {
        users.value = [
          {
            name: ls.t('All', 'Všetky'),
            surname: '',
            id: null
          }
        ]
        users.value.push(...res.data)
      })

  http
    .get('/question', {
      headers: {
        Authorization: `Bearer ${userStore.user.token}`
      }
    })
    .then((res) => {
      questions.value = res.data
      questions.value.forEach((q) => {
        q.subject = ''
        http.get(`/subject/${q.subject_id}`).then((res) => (q.subject = res.data.subject))
        if (userStore.user.admin)
          http
            .get(`/users/${q.user_id}`, {
              headers: {
                Authorization: `Bearer ${userStore.user.token}`
              }
            })
            .then((res) => (q.user = res.data))
      })
    })
}

watch(() => route.params, getData)
getData()
</script>
