<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center px-8 min-w-72">
      <div class="flex flex-col mb-32">
        <div class="text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ question.question }}
        </div>
        <div class="text-2xl">{{ question.subject }}</div>
        <div class="text-lg font-mono font-bold">{{ question.code }}</div>
      </div>
      <div
        v-if="!question.is_open_ended"
        class="flex flex-col space-y-4 mb-8 w-full max-w-96 items-center"
      >
        <AnswerOption
          v-for="ans in answers"
          :key="ans"
          :answer="ans.answer"
          @click="selAnswer = ans.answer"
          :selected="selAnswer == ans.answer"
        ></AnswerOption>
      </div>
      <div v-else class="w-full max-w-96">
        <FormKit
          :label="ls.t('Your answer', 'Vaša odpoveď')"
          v-model="selAnswer"
          type="text"
          input-class="w-full max-w-96"
          validation="required"
        ></FormKit>
      </div>
      <button @click="submit" class="w-full max-w-96" :disabled="!selAnswer">
        {{ ls.t('Submit', 'Odoslať') }}
      </button>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import AnswerOption from '@/components/AnswerOption.vue'

import { useLanguageStore } from '@/stores/language'
import http from '@/http'
import router from '@/router'
const ls = useLanguageStore()

const route = useRoute()

const question = ref({})
const answers = ref([])

const selAnswer = ref('')

const getData = () => {
  http
    .get(`/question/${route.params.code}`)
    .then((res) => {
      question.value = res.data

      http
        .get(`/subject/${question.value.subject_id}`)
        .then((res) => (question.value.subject = res.data.subject))

      if (!question.value.is_open_ended)
        http
          .get(`/answer/${route.params.code}`)
          .then((res) => (answers.value = res.data))
          .catch(() => {})
    })
    .catch(() => {
      router.push('/')
    })
}

const submit = () => {
  if (!selAnswer.value || !question.value) return
  http
    .post(`/answer/${route.params.code}`, {
      answer: question.value.is_open_ended ? selAnswer.value.toLowerCase() : selAnswer.value
    })
    .then(() => router.push(`/results/${route.params.code}`))
    .catch((err) => console.error(err))
}

getData()
</script>
