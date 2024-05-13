<template>
  <div class="flex flex-col space-y-4">
    <div
      v-for="ans in sortedAnswers"
      :key="ans"
      class="p-1 px-2 rounded-md flex flex-row justify-between min-w-96 bg-gradient-to-r from-[var(--clr),var(--perc)] via-[var(--clr),var(--perc)] to-[var(--color-bg-soft)]"
      :style="`--perc:${ans.percent}%; --clr:${ans.is_corrcet ? 'var(--color-good)' : 'var(--color-bg-mute)'}`"
    >
      <p>{{ ans.answer }}</p>
      <p>{{ ans.count }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  answers: Array
})

const max = ref(0)
const sortedAnswers = computed(() => {
  calcMax()
  let res = props.answers
  res.map((a) => {
    let ret = a
    ret.percent = Math.round((ret.count / max.value) * 100)
    return ret
  })
  console.log(res)
  return res.sort((a, b) => {
    return a.count < b.count
  })
})

const calcMax = () => {
  if (!props.answers) return
  props.answers.forEach((a) => {
    max.value = Math.max(max.value, a.count)
  })
}
</script>

<style scoped>
.ans {
}
</style>
