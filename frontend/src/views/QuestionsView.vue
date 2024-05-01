<template>
  <main class="flex justify-center">
    <div class="bg-gradient-to-b from-[var(--color-bg-soft)] p-8 rounded-xl">
      <div class="create-new mb-16">
        <div class="plus-sign">
          <v-icon name="fa-plus" scale="4"></v-icon>
        </div>
        <div class="content-center text-3xl">
          {{ langStore.t('Create new question', 'Vytvoriť novú otázku') }}
        </div>
      </div>
      <div class="flex flex-col space-y-4">
        <QuestionListItem></QuestionListItem>
        <QuestionListItem></QuestionListItem>
        <QuestionListItem></QuestionListItem>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import QuestionListItem from '@/components/QuestionListItem.vue'

const langStore = useLanguageStore()
</script>

<style scoped>
.create-new {
  @apply flex flex-row space-x-8 rounded-lg w-[32rem] p-4 transition-all duration-300 cursor-pointer;

  background-image: linear-gradient(
    180deg,
    var(--color-bg-mute),
    var(--color-bg-mute) 51%,
    var(--color-text)
  );
  background-position: 0 var(--y, 0);
  background-size: 200% 200%;
}

.create-new:hover {
  color: var(--color-heading);
  @apply shadow-black shadow-xl;
  --y: 100%;
}

.create-new:hover > .plus-sign {
  color: var(--color-text);
}

.plus-sign {
  background-color: var(--color-bg);
  color: var(--color-bg-mute);
  @apply min-w-24 min-h-24 rounded-lg content-center text-center transition-all duration-500;
}
</style>
