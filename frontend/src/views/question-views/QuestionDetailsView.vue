<template>
  <QRModal
    v-if="showQRModal"
    @close="showQRModal = false"
    :qrsrc="data.qrsrc"
    :code="data.code"
  ></QRModal>
  <ConfirmModal
    v-if="showConfirmModal"
    :message="ls.t('Are you sure?', 'Ste si istý?')"
    :description="
      ls.t(
        'Would you like to archive the answers to this question? After archiving, the counter will be reset.',
        'Chcete archivovať odpovede na túto otázku? Po archivácii sa počítadlo vynuluje.'
      )
    "
    allow-notes
    @cancel="showConfirmModal = false"
    @confirm="(notes) => confirmHandler(notes)"
  ></ConfirmModal>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div
      class="flex flex-col xl:flex-row xl:items-start xl:space-x-20 xl:justify-center items-center p-8"
    >
      <div class="flex flex-col mb-16 xl:m-0">
        <div class="flex xl:flex-col flex-row space-x-4 xl:space-x-0 items-center">
          <div class="flex flex-col">
            <div
              @click="showQRModal = true"
              class="size-fit min-w-36 bg-white p-2 rounded-md mb-2 transition-all ease-out hover:cursor-pointer hover:scale-110"
            >
              <img :src="data.qrsrc" alt="QR code" class="size-full" />
            </div>
            <h1
              class="text-center text-4xl font-mono font-bold transition-colors text-[var(--color-heading)]"
            >
              {{ data.code }}
            </h1>
          </div>
          <div class="flex flex-col justify-center xl:space-x-0 w-full mb-8">
            <button @click="archiveQuestion">{{ ls.t('Archive', 'Archivovať') }}</button>
            <button @click="dupQuestion">{{ ls.t('Duplicate', 'Duplikovať') }}</button>
            <button @click="exportQuestion">{{ ls.t('Export', 'Exportovať') }}</button>
            <button @click="$router.push(`/questions/edit/${data.code}`)">
              {{ ls.t('Edit', 'Upraviť') }}
            </button>
            <button @click="delQuestion" class="btn-danger">{{ ls.t('Delete', 'Vymazať') }}</button>
          </div>
        </div>
        <label
          v-if="data.is_open_ended"
          class="inline-flex justify-center items-center cursor-pointer"
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
      </div>
      <div class="flex flex-col">
        <div class="mb-28">
          <h1 v-if="userStore.user.admin && data.user" class="lg:text-xl lg:mb-4">
            {{ `${data.user.name} ${data.user.surname} [${data.user.email}]` }}
          </h1>
          <h1 class="lg:text-xl">{{ data.subject }}</h1>
          <h1
            class="text-3xl lg:text-5xl text-[var(--color-heading)] font-light mb-8 max-w-[90vw] lg:max-w-[32rem]"
          >
            {{ data.question }}
          </h1>
          <WordCloud v-if="wordCloudView" :answers="data.answers"></WordCloud>
          <MultiChoiceResults v-else :answers="data.answers"></MultiChoiceResults>
        </div>
        <div v-if="data.archived">
          <h1 class="text-4xl font-light mb-16">
            {{ ls.t('Archived answers:', 'Archivované odpovede:') }}
          </h1>
          <div v-for="arch in data.archived" :key="arch" class="flex flex-col mb-16">
            <div class="grid grid-cols-[10rem,1fr] mb-4 max-w-96 lg:max-w-[32rem]">
              <p class="font-bold">{{ ls.t('Time archived:', 'Čas archivácie:') }}</p>
              <p>{{ arch.archive_time }}</p>
              <p class="font-bold">{{ ls.t('Notes:', 'Poznámky:') }}</p>
              <p class="italic">{{ arch.notes }}</p>
            </div>
            <WordCloud v-if="wordCloudView" :answers="arch.answers"></WordCloud>
            <MultiChoiceResults v-else :answers="arch.answers"></MultiChoiceResults>
          </div>
        </div>
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
import ConfirmModal from '@/components/ConfirmModal.vue'

const ls = useLanguageStore()
const userStore = useUserStore()

const route = useRoute()

const data = ref({})
const showQRModal = ref(false)
const showConfirmModal = ref(false)
const confirmHandler = ref(() => {
  showConfirmModal.value = false
})

const wordCloudView = ref(false)

const getData = async () => {
  const question = (await http.get(`/question/${route.params.code}`)).data
  const answers = (await http.get(`/answer/${question.code}`)).data
  question.answers = answers ? answers : []
  question.subject = (await http.get(`/subject/${question.subject_id}`)).data.subject
  if (userStore.user.admin)
    question.user = (
      await http.get(`/users/${question.user_id}`, {
        headers: { Authorization: `Bearer ${userStore.user.token}` }
      })
    ).data
  question.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${import.meta.env.VITE_FRONTEND_BASE_URL}/${question.code}`

  data.value = question

  wordCloudView.value = data.value.is_open_ended ? true : false

  getArchived()
}

const delQuestion = () => {
  http
    .delete(`/question/${route.params.code}`, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then(() => {
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

const exportQuestion = () => {
  // eslint-disable-next-line no-unused-vars
  const { qrsrc, user, ...parsed } = data.value
  parsed.answers = parsed.answers.map((a) => {
    return {
      answer: a.answer,
      count: a.count,
      is_correct: a.is_correct
    }
  })

  saveJSON(parsed, 'export')
}

const saveJSON = (data, saveAs) => {
  let stringified = JSON.stringify(data, null, 2)
  let blob = new Blob([stringified], { type: 'application/json' })
  let url = URL.createObjectURL(blob)

  let a = document.createElement('a')
  a.download = saveAs + '.json'
  a.href = url
  a.id = saveAs
  document.body.appendChild(a)
  a.click()
  document.querySelector('#' + a.id).remove()
}

const archiveQuestion = () => {
  showConfirmModal.value = true
  confirmHandler.value = (notes) => {
    showConfirmModal.value = false

    http
      .post(
        `/archive/${route.params.code}`,
        {
          note: notes
        },
        {
          headers: { Authorization: `Bearer ${userStore.user.token}` }
        }
      )
      .then(() => router.go())
      .catch((err) => console.log(err))

    resetHandler()
  }
}

const resetHandler = () => {
  confirmHandler.value = () => {
    showConfirmModal.value = false
  }
}

const getArchived = () => {
  http
    .get(`/archive/${route.params.code}`, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then((res) => {
      data.value.archived = res.data.length > 0 ? res.data : null
      if (data.value.archived) {
        data.value.archived.sort((a, b) => {
          return Date.parse(a.archive_time) < Date.parse(b.archive_time)
        })
      }
    })
    .catch((err) => console.error(err))
}

getData()

watch(() => route.params.code, getData)
</script>

<style scoped>
button {
  background-color: var(--color-bg-soft);
  color: var(--color-text);
  border: none;
  @apply p-1 w-full;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
