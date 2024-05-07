<template>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex flex-col xl:flex-row xl:space-x-20 xl:justify-center items-center p-8">
      <div class="flex flex-col items-center mb-16 xl:m-0">
        <div
          @click="
            () => {
              if (data.active) showModal = true
            }
          "
          class="size-fit bg-white p-2 rounded-md mb-2 transition-all ease-out"
          :class="{
            'hover:cursor-pointer hover:scale-110': data.active,
            'opacity-40': !data.active
          }"
        >
          <img :src="data.qrsrc" alt="QR code" class="size-full" />
        </div>
        <h1
          class="text-center text-4xl font-mono font-bold transition-colors"
          :class="{
            'text-[var(--color-heading)]': data.active,
            'text-[var(--color-bg-mute)]': !data.active
          }"
        >
          {{ data.code }}
        </h1>
        <div class="flex flex-row xl:flex-col justify-center space-x-2 xl:space-x-0 w-full">
          <button @click="$router.push(`/questions/${data.id}`)">{{ 'Cancel' }}</button>
        </div>
      </div>
      <div class="flex flex-col">
        <FormKit type="form" @submit="() => {}" :actions="false" #default="{ state: { valid } }">
          <FormKit
            name="question"
            label="Question"
            v-model="data.question"
            validation="required"
          ></FormKit>
          <FormKit
            name="subject"
            label="Subject"
            v-model="data.subject"
            validation="required"
          ></FormKit>
          <h1 class="mb-2">Answers:</h1>
          <div class="flex flex-row space-x-2 mb-4">
            <button @click.prevent="data.answers.pop()" class="mt-0 flex-1">
              <v-icon name="fa-minus" scale="2"></v-icon>
            </button>
            <h1 class="content-center px-2 text-2xl">{{ data.answers.length }}</h1>
            <button
              @click.prevent="
                () => {
                  if (data.answers.length < 6) data.answers.push('')
                }
              "
              class="mt-0 flex-1"
            >
              <v-icon name="fa-plus" scale="2"></v-icon>
            </button>
          </div>
          <FormKit type="group" label="Answers">
            <FormKit
              v-for="ans in data.answers"
              :key="ans"
              :value="ans"
              validation="required"
              validation-label="Answer"
            ></FormKit>
          </FormKit>
          <FormKit label="Save" type="submit" :disabled="!valid" />
        </FormKit>
      </div>
    </div>
  </main>
</template>

<script setup>
import { watch } from 'vue'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/http'
// TODO get data from server

const route = useRoute()

// TODO update data on route change

const data = ref({
  answers: []
})
const showModal = ref(false)

const getData = async (id) => {
  const allQuestions = (await http.get('/question')).data
  const newData = allQuestions.filter((el) => el.id == id)[0]
  const answers = (await http.get(`/answer/${newData.code}`)).data.map((el) => el.answer)
  newData.answers = answers ? answers : []

  newData.subject = 'TODO'

  newData.active = Date.parse(newData.date_end) > Date.now()
  newData.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://node92.webte.fei.stuba.sk:8087/${newData.code}`

  data.value = newData
}

getData(route.params.id)

watch(
  () => route.params.id,
  (newId) => {
    getData(newId)
  }
)
</script>

<style scoped>
button {
  background-color: var(--color-bg-soft);
  color: var(--color-text);
  border: none;
  @apply p-1 w-24 xl:w-full;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
