<template>
  <div
    class="w-[32rem] p-8 flex flex-row flex-wrap justify-center items-center bg-[var(--color-bg-soft)] rounded-full"
  >
    <p
      v-for="ans in props.answers"
      :key="ans"
      class="max-w-fit max-h-min px-1"
      :style="`font-size:${Math.max(Math.round((ans.count / max) * 64), 16)}px`"
    >
      {{ ans.answer }}
    </p>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  answers: Array
})

const max = computed(() => {
  let res = 0
  props.answers.forEach((a) => {
    res = Math.max(res, a.count)
  })
  return res
})
</script>
