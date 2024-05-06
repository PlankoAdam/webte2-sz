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
            {{ langStore.t('Create new question', 'Vytvoriť novú otázku') }}
          </div>
        </div>
      </RouterLink>
      <div class="flex flex-col space-y-4">
        <RouterLink v-for="q in questions" :key="q.code" :to="`/questions/${q.code}`">
          <QuestionListItem
            :code="q.code"
            :question="q.question"
            :active="q.active"
          ></QuestionListItem>
        </RouterLink>
      </div>
    </div>
    <RouterView></RouterView>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import QuestionListItem from '@/components/QuestionListItem.vue'
import { RouterLink } from 'vue-router'
import { ref } from 'vue'

const langStore = useLanguageStore()

const dummyData = [
  {
    code: 'abc12',
    question: 'Lorem ipsum?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: 'gdr34',
    question: 'Dolor sit amet?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: false
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  }
]
const questions = ref([
  ...dummyData,
  ...dummyData,
  ...dummyData,
  ...dummyData,
  ...dummyData,
  ...dummyData,
  ...dummyData
])
</script>
