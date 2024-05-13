<template>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex justify-center items-center w-full h-full">
      <div class="max-w-fit bg-[var(--color-bg-soft)] p-8 rounded-xl">
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
            <button @click.prevent="nans--" class="mt-0 flex-1">
              <v-icon name="fa-minus" scale="2"></v-icon>
            </button>
            <h1 class="content-center px-2 text-2xl">{{ data.answers.length }}</h1>
            <button
              @click.prevent="
                () => {
                  if (nans < 6) nans++
                }
              "
              class="mt-0 flex-1"
            >
              <v-icon name="fa-plus" scale="2"></v-icon>
            </button>
          </div>
          <FormKit name="answers" type="group">
            <FormKitSchema :schema="schema" :data="data"></FormKitSchema>
          </FormKit>
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
import { computed } from 'vue'
import { ref } from 'vue'
import { reactive } from 'vue'

const userStore = useUserStore()

const schema = [
  {
    $el: 'ul',
    children: [
      {
        $formkit: 'text',
        validation: 'required',
        validationLabel: 'Answer',
        for: ['item', 'key', '$answers']
      }
    ]
  }
]

const nans = ref(0)
const subjects = ref([])

http.get('/subject').then((res) => {
  subjects.value = res.data
  console.log(subjects.value)
})

const data = reactive({
  answers: computed(() => {
    const res = []
    for (let i = 0; i < nans.value; i++) {
      res.push('')
    }
    return res
  })
})

const submitHandler = (formData) => {
  const parsed = {
    question: formData.question,
    subject_id: formData.subject_id,
    answers: Object.keys(formData.answers).map((key) => {
      return {
        answer: formData.answers[key]
      }
    })
  }

  if (userStore.user.admin) parsed.user_id = formData.user_id

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
