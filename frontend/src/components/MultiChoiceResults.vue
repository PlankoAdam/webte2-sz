<template>
  <div class="flex flex-col space-y-2">
    <div
      v-for="ans in sortedAnswers"
      :key="ans"
      class="p-2 ps-4 rounded-md flex flex-row justify-between min-w-96 max-w-[32rem] bg-gradient-to-r from-[var(--clr),var(--perc)] via-[var(--clr),var(--perc)] to-[var(--color-bg-soft)]"
      :style="`--perc:${ans.fill_percent}%; --clr:${ans.is_correct ? 'var(--color-good)' : 'var(--color-bg-mute)'};`"
      :class="{ 'text-white': ans.is_correct }"
    >
      <p class="overflow-hidden text-ellipsis whitespace-nowrap me-4 text-lg">
        {{ ans.answer }}
      </p>
      <p class="bg-[var(--color-bg)] text-[var(--color-text)] px-3 rounded-md min-w-fit">
        {{ `${ans.percent}% (${ans.count})` }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  answers: Array
})

const max = ref(0)
const total = ref(0)
const sortedAnswers = computed(() => {
  calcMax()
  calcTotal()
  let res = props.answers ? props.answers : []
  res.map((a) => {
    let ret = a
    ret.fill_percent = max.value == 0 ? 0 : Math.round((ret.count / max.value) * 100)
    ret.percent = total.value == 0 ? 0 : Math.round((ret.count / total.value) * 100)
    return ret
  })
  console.log(res)
  return res.sort((a, b) => {
    return a.count < b.count
  })
})

const calcMax = () => {
  if (!props.answers) return
  max.value = 0
  props.answers.forEach((a) => {
    max.value = Math.max(max.value, a.count)
  })
}

const calcTotal = () => {
  if (!props.answers) return
  total.value = 0
  props.answers.forEach((a) => {
    total.value += a.count
  })
}
</script>
