<template>
  <div>
    <QRModal
      v-if="showQRmodal"
      @close="showQRmodal = false"
      :qrsrc="props.qrsrc"
      :code="props.code"
    ></QRModal>
    <div
      class="flex flex-row space-x-8 rounded-lg w-[32rem] p-4 text-[var(--ac400)] dark:text-[var(--ac500)] transition-all"
      :class="{
        active: props.active,
        'bg-[var(--ac200)] dark:bg-[var(--ac900)]': !props.active
      }"
    >
      <div
        class="min-w-24 min-h-24 max-w-24 max-h-24 p-1 bg-white rounded-lg content-center text-center"
      >
        <img
          @click="
            () => {
              if (props.active) showQRmodal = true
            }
          "
          :src="props.qrsrc"
          alt="QR"
          class="size-full rounded-md"
          :class="{ 'cursor-pointer': props.active, 'opacity-40': !props.active }"
        />
      </div>
      <div class="flex flex-col justify-center">
        <span class="text-3xl font-light">{{ props.question }} </span>
        <div class="text-lg mb-2 flex flex-row space-x-2">
          <div class="">
            {{ langStore.t('Code', 'Kód') }}
          </div>
          <div class="font-mono font-bold">
            {{ props.code }}
          </div>
        </div>
        <div class="flex flex-row space-x-4 select-none">
          <p
            v-if="!props.active"
            @click="$emit('activate')"
            class="transition-all cursor-pointer activate-btn"
          >
            {{ langStore.t('Activate', 'Aktivovať') }}
          </p>
          <p v-if="props.active" @click="$emit('deactivate')" class="transition-all cursor-pointer">
            {{ langStore.t('Deactivate', 'Deaktivovať') }}
          </p>
          <p
            class="transition-all"
            :class="{
              'cursor-pointer': props.active
            }"
          >
            {{ langStore.t('Edit', 'Upraviť') }}
          </p>
          <p
            @click="
              () => {
                if (props.active) showQRmodal = true
              }
            "
            class="transition-all"
            :class="{
              'cursor-pointer': props.active
            }"
          >
            {{ langStore.t('Show', 'Ukázať') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
const langStore = useLanguageStore()

import { ref } from 'vue'
import QRModal from './QRModal.vue'

const props = defineProps({
  code: String,
  question: String,
  qrsrc: String,
  active: Boolean
})

const showQRmodal = ref(false)
</script>

<style scoped>
.active {
  @apply text-[var(--ac950)] dark:text-[var(--ac050)];

  background-image: linear-gradient(180deg, var(--ac300), var(--ac400) 51%, var(--ac400));
  @media (prefers-color-scheme: dark) {
    color: var(--ac050);
    background-image: linear-gradient(180deg, var(--ac600), var(--ac700) 51%, var(--ac700));
  }
  background-position: 0 var(--y, 100%);
  background-size: 200% 200%;
}

.active:hover {
  --y: 0;
}

.active p {
  @apply text-[var(--ac950)] hover:bg-[var(--ac500)];
  @apply dark:text-[var(--ac050)] dark:hover:bg-[var(--ac500)];
}

div p {
  @apply px-2 rounded-md;
}

.activate-btn {
  @apply text-[var(--ac950)] hover:bg-[var(--ac400)];
  @apply dark:text-[var(--ac050)] dark:hover:bg-[var(--ac600)];
}
</style>
