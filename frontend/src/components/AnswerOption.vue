<template>
  <div
    class="w-96 rounded-lg bg-[var(--color-bg-soft)] text-[var(--color-heading)] text-xl p-2 ps-4 capitalize transition-all cursor-pointer border-4"
    :class="{
      'border-sky-500 dark:bg-sky-900 bg-sky-700 text-white': props.selected,
      'border-transparent hover:bg-[var(--color-bg-mute)]': !props.selected
    }"
  >
    {{ props.answer }}
  </div>
</template>

<script setup>
const props = defineProps({
  answer: String,
  selected: Boolean
})
</script>
