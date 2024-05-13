<template>
  <QRModal
    v-if="showModal"
    @close="showModal = false"
    :qrsrc="data.qrsrc"
    :code="data.code"
  ></QRModal>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex flex-col xl:flex-row xl:space-x-20 xl:justify-center items-center p-8">
      <div class="flex flex-col items-center mb-16 xl:m-0">
        <div
          @click="showModal = true"
          class="size-fit bg-white p-2 rounded-md mb-2 transition-all ease-out hover:cursor-pointer hover:scale-110"
        >
          <img :src="data.qrsrc" alt="QR code" class="size-full" />
        </div>
        <h1
          class="text-center text-4xl font-mono font-bold transition-colors text-[var(--color-heading)]"
        >
          {{ data.code }}
        </h1>
        <div class="flex flex-row xl:flex-col justify-center space-x-2 xl:space-x-0 w-full">
          <button @click="$router.push(`/questions/edit/${data.code}`)">{{ 'Edit' }}</button>
          <button class="btn-danger">{{ 'Delete' }}</button>
        </div>
      </div>
      <div class="flex flex-col">
        <h1 class="text-xl mb-4">{{ data.subject }}</h1>
        <h1 class="text-5xl font-light mb-8 w-[32rem]">{{ data.question }}</h1>
        <ul class="flex flex-col space-y-2 max-w-96">
          <li
            v-for="ans in data.answers"
            :key="ans"
            class="p-1 px-4 rounded-sm bg-[var(--color-bg-soft)]"
          >
            {{ ans }}
          </li>
        </ul>
      </div>
    </div>
  </main>
</template>

<script setup>
import QRModal from '@/components/QRModal.vue'
import { watch } from 'vue'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import http from '@/http'

// import { useLanguageStore } from '@/stores/language'
// import { useUserStore } from '@/stores/user'

// const langStore = useLanguageStore()
// const userStore = useUserStore()

const route = useRoute()

const data = ref({})
const showModal = ref(false)

const getData = async () => {
  const question = (await http.get(`/question/${route.params.code}`)).data[0]
  const answers = (await http.get(`/answer/${question.code}`)).data.map((el) => el.answer)
  question.answers = answers ? answers : []
  question.subject = (await http.get(`/subject/${question.subject_id}`)).data.subject
  question.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://node92.webte.fei.stuba.sk:8087/${question.code}`

  data.value = question
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
