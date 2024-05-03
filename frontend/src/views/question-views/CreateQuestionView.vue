<template>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex justify-center items-center w-full h-full">
      <div class="max-w-fit bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
        <FormKit
          type="form"
          @submit="submitHandler"
          :actions="false"
          #default="{ state: { valid } }"
        >
          <FormKit name="question" label="Question" type="text" validation="required"></FormKit>
          <FormKit name="subject" label="Subject" type="text" validation="required"></FormKit>
          <h1 class="mb-2">Answers:</h1>
          <div class="flex flex-row space-x-2 mb-4 text-xl">
            <button @click.prevent="nans--" class="mt-0 flex-1">-</button>
            <h1 class="content-center px-2">{{ data.answers.length }}</h1>
            <button
              @click.prevent="
                () => {
                  if (nans < 6) nans++
                }
              "
              class="mt-0 flex-1"
            >
              +
            </button>
          </div>
          <!-- <FormKit
            name="nans"
            v-model="nans"
            label="Number of answers"
            type="number"
            value="0"
            validation="required"
            min="0"
            max="6"
          ></FormKit> -->
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
import { computed } from 'vue'
import { ref } from 'vue'
import { reactive } from 'vue'

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
    subject: formData.subject,
    answers: Object.keys(formData.answers).map((key) => formData.answers[key])
  }

  console.log(parsed)

  // TODO get unique code from server
  // TODO get QR code from server
}
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
