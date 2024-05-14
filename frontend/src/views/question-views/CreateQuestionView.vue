<template>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full min-h-[85vh]"
  >
    <div class="flex justify-center w-full h-full mt-8 lg:mt-0">
      <div class="max-w-fit max-h-fit h-fit bg-[var(--color-bg-soft)] p-8 rounded-xl">
        <FormKit
          type="form"
          @submit="submitHandler"
          :actions="false"
          #default="{ state: { valid } }"
        >
          <FormKit name="question" label="Question" type="text" validation="required"></FormKit>
          <FormKit
            name="subject_id"
            label="Subject"
            type="select"
            placeholder="Select a subject"
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
          <FormKit
            v-if="userStore.user.admin"
            name="user_id"
            label="User"
            type="select"
            placeholder="Select a user"
            validation="required"
            :options="
              users.map((el) => {
                return {
                  label: `${el.name} ${el.surname} (${el.email})`,
                  value: el.id
                }
              })
            "
          ></FormKit>
          <h1 class="mb-2">Answers:</h1>
          <div class="flex flex-row space-x-2 mb-4">
            <button @click.prevent="nans.pop()" class="mt-0 flex-1">
              <v-icon name="fa-minus" scale="2"></v-icon>
            </button>
            <h1 class="content-center px-2 text-2xl">{{ nans.length }}</h1>
            <button
              @click.prevent="
                () => {
                  if (nans.length < 6) nans.push('')
                }
              "
              class="mt-0 flex-1"
            >
              <v-icon name="fa-plus" scale="2"></v-icon>
            </button>
          </div>
          <FormKit name="answers" type="group">
            <FormKit v-for="a in nans" :key="a" type="group">
              <div class="flex flex-row space-x-2">
                <FormKit
                  name="is_correct"
                  type="checkbox"
                  :value="false"
                  input-class="size-6 min-w-0 mt-2 mb-2 cursor-pointer"
                ></FormKit>
                <FormKit name="answer" input-class="max-w-52 min-w-52 mb-2"></FormKit>
              </div>
            </FormKit>
          </FormKit>
          <span v-if="nans.length > 0" class="text-sm">Check the correct answer(s).</span>
          <FormKit label="Create" type="submit" :disabled="!valid" />
        </FormKit>
      </div>
    </div>
  </main>
</template>

<script setup>
import http from '@/http'
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { ref } from 'vue'

const userStore = useUserStore()

const nans = ref([])
const subjects = ref([])

http.get('/subject').then((res) => {
  subjects.value = res.data
  console.log(subjects.value)
})

const submitHandler = (formData) => {
  const parsed = {
    question: formData.question,
    subject_id: formData.subject_id,
    answers: Object.keys(formData.answers).map((key) => {
      return formData.answers[key]
    })
  }

  if (userStore.user.admin) parsed.user_id = formData.user_id

  console.log(parsed)

  http
    .post('/question', parsed, {
      headers: { Authorization: `Bearer ${userStore.user.token}` }
    })
    .then(() => {
      router.push(`/questions`)
    })
    .catch((err) => console.error(err))
}

const users = ref([])

const getUsers = () => {
  http
    .get('/users', { headers: { Authorization: `Bearer ${userStore.user.token}` } })
    .then((res) => (users.value = res.data))
    .catch((err) => console.error(err))
}

if (userStore.user.admin) getUsers()
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
