<template>
  <div
    @click="$emit('close')"
    class="fixed z-10 min-w-full min-h-full bg-black bg-opacity-50 top-0 left-0 flex flex-col justify-center items-center"
  >
    <div
      @click.stop=""
      class="bg-[var(--color-bg-soft)] p-4 rounded-lg size-fit shadow-2xl shadow-black"
    >
      <div class="h-[min(80vh,80vw)] w-[min(80vh,80vw)] bg-green-400 mb-4"></div>
      <h1 class="text-6xl text-[var(--color-heading)] font-mono text-center">abc123</h1>
    </div>
  </div>
</template>
