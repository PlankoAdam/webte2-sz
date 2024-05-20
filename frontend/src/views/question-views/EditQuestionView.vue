<template>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex flex-col xl:flex-row xl:space-x-20 xl:justify-center items-center p-8">
      <div class="flex flex-col items-center mb-16 xl:m-0">
        <div class="size-fit bg-white p-2 rounded-md mb-2">
          <img :src="data.qrsrc" alt="QR code" class="size-full" />
        </div>
        <h1
          class="text-center text-4xl font-mono font-bold transition-colors text-[var(--color-heading)]"
        >
          {{ data.code }}
        </h1>
        <div class="flex flex-row xl:flex-col justify-center space-x-2 xl:space-x-0 w-full">
          <button @click="$router.push(`/questions/${data.code}`)">
            {{ ls.t('Cancel', 'Zrušiť') }}
          </button>
        </div>
      </div>
      <div class="flex flex-col">
        <FormKit type="form" @submit="formHandler" :actions="false" #default="{ state: { valid } }">
          <FormKit
            name="question"
            :label="ls.t('Question', 'Otázka')"
            v-model="data.question"
            validation="required"
          ></FormKit>
          <FormKit
            name="subject_id"
            :label="ls.t('Subject', 'Predmet')"
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
          <FormKit :label="ls.t('Save', 'Uložiť')" type="submit" :disabled="!valid" />
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
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { useLanguageStore } from '@/stores/language'

const route = useRoute()

const ls = useLanguageStore()

const data = ref({})
const subjects = ref([])

http.get('/subject').then((res) => {
  subjects.value = res.data
  console.log(subjects.value)
})

const getData = async () => {
  const question = (await http.get(`/question/${route.params.code}`)).data
  question.subject = (await http.get(`/subject/${question.subject_id}`)).data.name
  question.qrsrc = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${import.meta.env.FRONTEND_BASE_URL}/${question.code}`

  data.value = question
}

const formHandler = (formData) => {
  http
    .put(
      `/question/${route.params.code}`,
      {
        question: formData.question,
        subject: formData.subject_id
      },
      { headers: { Authorization: `Bearer ${useUserStore().user.token}` } }
    )
    .then(() => router.push(`/questions/${route.params.code}`))
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
  @apply p-1 w-24 xl:w-full;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
