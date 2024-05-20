<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center px-8 min-w-72">
      <div class="flex flex-col mb-8">
        <div class="text-3xl lg:text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ question.question }}
        </div>
        <div class="lg:text-2xl">{{ question.subject }}</div>
        <div class="lg:text-lg font-mono font-bold">{{ question.code }}</div>
      </div>

      <label
        v-if="question.is_open_ended"
        class="inline-flex w-full items-center cursor-pointer mb-16"
      >
        <input
          type="checkbox"
          v-model="wordCloudView"
          :checked="wordCloudView"
          class="sr-only peer"
        />
        <div
          class="relative w-11 h-6 bg-[var(--color-bg-mute)] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[var(--acc500)]"
        ></div>
        <span class="ms-3 text-lg">WordCloud</span>
      </label>

      <div>
        <h1 class="uppercase text-2xl font-light mb-8">{{ ls.t('Answers:', 'Odpovede:') }}</h1>
        <WordCloud v-if="wordCloudView" :answers="answers"></WordCloud>
        <MultiChoiceResults v-else :answers="answers"></MultiChoiceResults>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import http from '@/http'
import { useRoute } from 'vue-router'
import MultiChoiceResults from '@/components/MultiChoiceResults.vue'
import WordCloud from '@/components/WordCloud.vue'
import { useLanguageStore } from '@/stores/language'

const route = useRoute()
const ls = useLanguageStore()

const question = ref({})
const answers = ref([])

const wordCloudView = ref(false)

const getData = () => {
  http
    .get(`/question/${route.params.code}`)
    .then((res) => {
      question.value = res.data
      wordCloudView.value = question.value.is_open_ended ? true : false
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
