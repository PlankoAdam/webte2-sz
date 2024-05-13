<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center px-8 min-w-72">
      <div class="flex flex-col mb-32">
        <div class="text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ question.question }}
        </div>
        <div class="text-lg">{{ question.subject }}</div>
        <div class="text-lg font-mono">{{ question.code }}</div>
      </div>

      <MultiChoiceResults :answers="answers"></MultiChoiceResults>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import http from '@/http'
import { useRoute } from 'vue-router'
import MultiChoiceResults from '@/components/MultiChoiceResults.vue'

const route = useRoute()

const question = ref({})
const answers = ref([])

const getData = () => {
  http
    .get(`/question/${route.params.code}`)
    .then((res) => {
      question.value = res.data[0]
      http
        .get(`/subject/${question.value.subject_id}`)
        .then((res) => (question.value.subject = res.data.subject))
        .catch((err) => console.error(err))
    })
    .catch((err) => console.error(err))

  http
    .get(`/answer/${route.params.code}`)
    .then((res) => (answers.value = res.data))
    .catch((err) => console.error(err))
}

getData()
</script>
