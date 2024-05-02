<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <FormKit type="form" @submit="submitHandler">
        <FormKit name="question" label="Question" type="text" validation="required"></FormKit>
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
      </FormKit>
    </div>
  </main>
</template>

<script setup>
import { computed } from 'vue'
import { ref } from 'vue'
import { reactive } from 'vue'

// TODO get data base on id
// import { useRoute } from 'vue-router'
// const route = useRoute()
// const id = route.params.id

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
    answers: Object.keys(formData.answers).map((key) => formData.answers[key])
  }

  console.log(parsed)
}
</script>
