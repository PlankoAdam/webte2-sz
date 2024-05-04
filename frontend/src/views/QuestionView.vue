<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center px-8 min-w-72">
      <div class="flex flex-col mb-32">
        <div class="text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ questionData.question }}
        </div>
        <div class="text-lg font-mono">{{ questionData.code }}</div>
      </div>
      <div
        v-if="questionData.answers.length > 0"
        class="flex flex-col space-y-4 mb-8 w-full max-w-96 items-center"
      >
        <AnswerOption
          v-for="ans in questionData.answers"
          :key="ans"
          :answer="ans"
          @click="selAnswer = ans"
          :selected="selAnswer == ans"
        ></AnswerOption>
      </div>
      <div v-else class="w-full max-w-96">
        <FormKit
          :label="langStore.t('Your answer', 'Vaša odpoveď')"
          :v-model="selAnswer"
          type="text"
          input-class="w-full"
          validation="required"
        ></FormKit>
      </div>
      <button class="w-full max-w-96">Submit</button>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import AnswerOption from '@/components/AnswerOption.vue'

import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()

const route = useRoute()
const code = route.params.code

// TODO get data from server
// dummy data
const questionData = ref({
  code,
  question: 'Lorem ipsum dolor sit amet?',
  // answers: []
  answers: ['answer 1', 'answer 2', 'answer 3']
})

const selAnswer = ref('')
</script>
