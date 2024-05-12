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
        <FormKit type="form" @submit="formHandler" :actions="false" #default="{ state: { valid } }">
          <FormKit
            name="question"
            label="Question"
            v-model="data.question"
            validation="required"
          ></FormKit>
          <FormKit
            name="subject_id"
            label="Subject"
            type="select"
            placeholder="Select a subject"
            v-model="data.subject_id"
            :options="
              subjects.map((el) => {
                return {
                  label: el.subject,
                  value: el.id
                }
              })
            "
            validation="required"
          ></FormKit>
          <!-- <h1 class="mb-2">Answers:</h1>
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
          </FormKit> -->
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

const route = useRoute()

const showModal = ref(false)

const data = ref({})
const subjects = ref([])

http.get('/subject').then((res) => {
  subjects.value = res.data
  console.log(subjects.value)
})

const getData = async () => {
  const question = (await http.get(`/question/${route.params.code}`)).data[0]
  question.subject = (await http.get(`/subject/${question.subject_id}`)).data.name
  question.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://node92.webte.fei.stuba.sk:8087/${question.code}`

  data.value = question
}

const formHandler = (formData) => {
  console.log(formData)
  // TODO waiting for put endpoint
}

getData(route.params.code)

watch(() => route.params.code, getData)
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
