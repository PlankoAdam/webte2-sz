<template>
  <div
    class="fixed z-50 min-w-[100vw] min-h-[100vh] bg-black bg-opacity-70 top-0 left-0 flex flex-col justify-center items-center"
  >
    <div class="p-8 rounded-md min-w-80 max-w-[90vw] bg-[var(--color-bg-soft)] lg:max-w-96">
      <div class="mb-8">
        <h1 class="text-[var(--color-heading)] font-light text-4xl mb-4">{{ props.message }}</h1>
        <p>{{ props.description }}</p>
      </div>
      <FormKit
        v-if="props.allowNotes"
        v-model="notes"
        :label="ls.t('Notes', 'Poznámky')"
        type="textarea"
        input-class="w-full max-w-full"
      ></FormKit>
      <div class="flex flex-row space-x-4 justify-end">
        <button @click="$emit('cancel')">{{ ls.t('Cancel', 'Zrušiť') }}</button>
        <button @click="$emit('confirm', notes)" class="btn-danger">
          {{ ls.t('Confirm', 'Potvrdiť') }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import { ref } from 'vue'

const ls = useLanguageStore()

const notes = ref('')

const props = defineProps({
  message: String,
  description: String,
  allowNotes: Boolean
})
</script>

<style scoped>
button {
  background-color: var(--color-bg-soft);
  color: var(--color-text);
  border: none;
  @apply p-1 w-full max-w-28;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
