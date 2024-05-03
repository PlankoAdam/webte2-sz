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
          <button @click="$router.push(`/questions/${data.code}`)">{{ 'Cancel' }}</button>
        </div>
      </div>
      <div class="flex flex-col">
        <FormKit type="form" @submit="() => {}" :actions="false" #default="{ state: { valid } }">
          <FormKit
            name="question"
            label="Question"
            :value="data.question"
            validation="required"
          ></FormKit>
          <FormKit
            name="subject"
            label="Subject"
            :value="data.subject"
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
// TODO get data from server

const route = useRoute()

const dummyData = {
  code: route.params.id,
  question: 'Lorem ipsum?',
  subject: 'webte',
  qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
  active: false,
  answers: ['ans1', 'ans2', 'ans3']
}

// TODO update data on route change
watch(
  () => route.params.id,
  (newId) => (dummyData.code = newId)
)

const data = ref(dummyData)
const showModal = ref(false)
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
