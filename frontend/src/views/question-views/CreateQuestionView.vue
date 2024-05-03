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
          <FormKit
            name="nans"
            v-model="nans"
            label="Number of answers"
            type="number"
            value="0"
            validation="required"
            min="0"
            max="6"
          ></FormKit>
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
