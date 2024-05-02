<template>
  <main class="flex justify-center">
    <div class="flex flex-col items-center">
      <div class="flex flex-col mb-32">
        <div class="text-6xl font-light text-[var(--color-heading)] mb-4">
          {{ questionData.question }}
        </div>
        <div class="text-lg font-mono ms-8">{{ questionData.code }}</div>
      </div>
      <div v-if="questionData.answers.length > 0" class="flex flex-col space-y-4">
        <AnswerOption
          v-for="ans in questionData.answers"
          :key="ans"
          :answer="ans"
          @click="selAnswer = ans"
          :selected="selAnswer == ans"
        ></AnswerOption>
      </div>
      <div v-else>
        <FormKit
          label="Your answer"
          :v-model="selAnswer"
          type="text"
          input-class="min-w-96"
          validation="required"
        ></FormKit>
      </div>
      <div>
        <button class="min-w-96 mt-16">Submit</button>
      </div>
    </div>
  </main>
</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import AnswerOption from '@/components/AnswerOption.vue'

const route = useRoute()
const code = route.params.code

// TODO get data from server
// dummy data
const questionData = ref({
  code,
  question: 'Lorem ipsum dolor sit amet?',
  answers: []
})

const selAnswer = ref('')
</script>
