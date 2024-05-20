<template>
  <div class="flex flex-col space-y-2">
    <div
      v-for="ans in sortedAnswers"
      :key="ans"
      class="p-2 ps-4 rounded-md flex flex-row justify-between min-w-80 max-w-[90vw] lg:max-w-[32rem] bg-gradient-to-r from-[var(--clr),var(--perc)] via-[var(--clr),var(--perc)] to-[var(--color-bg-soft)] dark:from-[var(--clr-dark),var(--perc)] dark:via-[var(--clr-dark),var(--perc)] dark:to-[var(--color-bg-soft)]"
      :style="`--perc:${ans.fill_percent}%; --clr:${ans.is_correct ? 'var(--good500)' : 'var(--sec400)'}; --clr-dark:${ans.is_correct ? 'var(--good700)' : 'var(--sec800)'}`"
    >
      <v-icon
        v-if="ans.is_correct"
        name="fa-check"
        scale="1.5"
        class="absolute -translate-x-12"
      ></v-icon>
      <p
        class="overflow-hidden text-ellipsis whitespace-nowrap me-4 text-lg"
        :class="{ 'font-bold italic': ans.is_correct }"
      >
        {{ ans.answer }}
      </p>
      <p class="bg-[var(--color-bg)] text-[var(--color-text)] px-3 rounded-md min-w-fit">
        {{ `${ans.percent}% (${ans.count})` }}
      </p>
    </div>
    <div class="flex flex-row justify-between w-full ps-2 pe-5 text-xl">
      <p>{{ ls.t('Total:', 'Celkom:') }}</p>
      <p class="font-bold">{{ total }}</p>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useLanguageStore } from '@/stores/language'

const ls = useLanguageStore()

const props = defineProps({
  answers: Array
})

const max = ref(0)
const total = ref(0)
const sortedAnswers = computed(() => {
  calcMax()
  calcTotal()
  let res = props.answers ? JSON.parse(JSON.stringify(props.answers)) : []
  res.map((a) => {
    let ret = a
    ret.fill_percent = max.value == 0 ? 0 : Math.round((ret.count / max.value) * 100)
    ret.percent = total.value == 0 ? 0 : Math.round((ret.count / total.value) * 100)
    return ret
  })
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
