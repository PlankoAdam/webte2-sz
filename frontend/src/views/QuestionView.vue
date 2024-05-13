<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center px-8 min-w-72">
      <div class="flex flex-col mb-32">
        <div class="text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ data.question }}
        </div>
        <div class="text-lg">{{ data.subject }}</div>
        <div class="text-lg font-mono">{{ data.code }}</div>
      </div>
      <div
        v-if="answers.length > 0"
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
          :label="langStore.t('Your answer', 'Vaša odpoveď')"
          v-model="selAnswer"
          type="text"
          input-class="w-full"
          validation="required"
        ></FormKit>
      </div>
      <button @click="submit" class="w-full max-w-96" :disabled="!selAnswer">Submit</button>
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
const langStore = useLanguageStore()

const route = useRoute()

const data = ref({})
const answers = ref([])

const selAnswer = ref('')

const getData = () => {
  http
    .get(`/question/${route.params.code}`)
    .then((res) => {
      data.value = res.data[0]

      http
        .get(`/subject/${data.value.subject_id}`)
        .then((res) => (data.value.subject = res.data.subject))

      if (!data.value.is_open_ended)
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
  if (!selAnswer.value || !data.value) return
  http
    .post(`/answer/${route.params.code}`, {
      answer: data.value.is_open_ended ? selAnswer.value.toLowerCase() : selAnswer.value
    })
    .then((res) => console.log(res))
    .catch((err) => console.error(err))
}

getData()
</script>
