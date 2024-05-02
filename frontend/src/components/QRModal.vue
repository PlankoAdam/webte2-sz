<template>
  <div
    @click="$emit('close')"
    class="fixed z-50 min-w-[100vw] min-h-[100vh] bg-black bg-opacity-50 top-0 left-0 flex flex-col justify-center items-center"
  >
    <div
      @click.stop=""
      class="bg-[var(--color-bg-soft)] p-4 rounded-lg size-fit shadow-2xl shadow-black"
    >
      <div class="p-2 rounded-lg bg-white mb-4">
        <img :src="props.qrsrc" class="size-[min(80vh,80vw)]" />
      </div>
      <h1 class="text-6xl text-[var(--color-heading)] font-mono text-center">{{ props.code }}</h1>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  qrsrc: String,
  code: String
})
</script>
