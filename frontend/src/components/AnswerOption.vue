<template>
  <div
    class="w-full rounded-lg bg-[var(--color-bg-soft)] text-xl p-2 ps-4 capitalize transition-all cursor-pointer border-4"
    :class="{
      'border-[var(--acc600)] dark:bg-[var(--acc700)] bg-[var(--acc500)] dark:text-[var(--acc050)] text-[var(--acc950)]':
        props.selected,
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
