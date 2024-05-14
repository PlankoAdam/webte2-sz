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
          <div class="flex flex-col">
            <button>{{ ls.t('Archive', 'Archivovať') }}</button>
            <button @click="dupQuestion">{{ ls.t('Duplicate', 'Duplikovať') }}</button>
          </div>
          <div class="flex flex-col">
            <button @click="$router.push(`/questions/edit/${data.code}`)">
              {{ ls.t('Edit', 'Upraviť') }}
            </button>
            <button @click="delQuestion" class="btn-danger">{{ ls.t('Delete', 'Vymazať') }}</button>
          </div>
        </div>
      </div>
      <div class="flex flex-col">
        <h1 v-if="userStore.user.admin && data.user" class="text-xl mb-8">
          {{ `${data.user.name} ${data.user.surname} [${data.user.email}]` }}
        </h1>
        <h1 class="text-xl">{{ data.subject }}</h1>
        <h1
          class="text-5xl text-[var(--color-heading)] font-light mb-8 min-w-[32rem] max-w-[32rem]"
        >
          {{ data.question }}
        </h1>
        <MultiChoiceResults v-if="!data.is_open_ended" :answers="data.answers"></MultiChoiceResults>
        <WordCloud v-else :answers="data.answers"></WordCloud>
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
import { useLanguageStore } from '@/stores/language'

import { useUserStore } from '@/stores/user'
import router from '@/router'
import MultiChoiceResults from '@/components/MultiChoiceResults.vue'
import WordCloud from '@/components/WordCloud.vue'

const ls = useLanguageStore()
const userStore = useUserStore()

const route = useRoute()

const data = ref({})
const showModal = ref(false)

const getData = async () => {
  const question = (await http.get(`/question/${route.params.code}`)).data[0]
  const answers = (await http.get(`/answer/${question.code}`)).data
  question.answers = answers ? answers : []
  question.subject = (await http.get(`/subject/${question.subject_id}`)).data.subject
  if (userStore.user.admin)
    question.user = (
      await http.get(`/users/${question.user_id}`, {
        headers: { Authorization: `Bearer ${userStore.user.token}` }
      })
    ).data
  question.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://node92.webte.fei.stuba.sk:8087/${question.code}`

  data.value = question
}

const delQuestion = () => {
  http
    .delete(`/question/${route.params.code}`, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then((res) => {
      console.log(res)
      router.push('/questions')
    })
    .catch((err) => console.error(err))
}

const dupQuestion = () => {
  const parsed = {
    subject_id: data.value.subject_id,
    user_id: data.value.user_id,
    question: data.value.question,
    answers: data.value.is_open_ended
      ? []
      : data.value.answers.map((a) => {
          return {
            answer: a.answer,
            is_correct: a.is_correct
          }
        })
  }

  http
    .post('/question', parsed, { headers: { Authorization: `Bearer ${userStore.user.token}` } })
    .then((res) => {
      router.push(`/questions/${res.data.code}`)
    })
    .catch((err) => console.error(err))
}

getData(route.params.code)

watch(() => route.params.code, getData)
</script>

<style scoped>
button {
  background-color: var(--color-bg-soft);
  color: var(--color-text);
  border: none;
  @apply p-1 w-36 xl:w-full;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
