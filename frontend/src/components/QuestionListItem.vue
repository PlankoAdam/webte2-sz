<template>
  <QRModal
    v-if="showQRmodal"
    @close="showQRmodal = false"
    :qrsrc="props.qrsrc"
    :code="props.code"
  ></QRModal>
  <div
    class="flex flex-row space-x-8 rounded-lg w-[32rem] p-4"
    :class="{
      'bg-[var(--color-bg-mute)]': props.active,
      'bg-[var(--color-bg-soft)]': !props.active
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
      <span class="text-3xl font-light" :class="{ 'text-[var(--color-heading)]': props.active }"
        >{{ props.question }}
      </span>
      <div class="text-lg mb-2 flex flex-row space-x-2">
        <div
          class="text-[var(--color-bg-mute)]"
          :class="{ 'text-[var(--color-text)]': props.active }"
        >
          {{ langStore.t('Code', 'Kód') }}
        </div>
        <div
          class="font-mono"
          :class="{
            'text-[var(--color-heading)]': props.active,
            'text-[var(--color-bg-mute)]': !props.active
          }"
        >
          {{ props.code }}
        </div>
      </div>
      <div class="flex flex-row space-x-4 select-none">
        <p
          v-if="!props.active"
          @click="$emit('activate')"
          class="transition-all text-[var(--color-text)] hover:text-[var(--color-heading)] cursor-pointer"
        >
          {{ langStore.t('Activate', 'Aktivovať') }}
        </p>
        <p
          v-if="props.active"
          @click="$emit('deactivate')"
          class="transition-all text-[var(--color-text)] hover:text-[var(--color-heading)] cursor-pointer"
        >
          {{ langStore.t('Deactivate', 'Deaktivovať') }}
        </p>
        <p
          class="transition-all text-[var(--color-bg-mute)]"
          :class="{
            'text-[var(--color-text)] hover:text-[var(--color-heading)] cursor-pointer':
              props.active
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
          class="transition-all text-[var(--color-bg-mute)]"
          :class="{
            'text-[var(--color-text)] hover:text-[var(--color-heading)] cursor-pointer':
              props.active
          }"
        >
          {{ langStore.t('Show', 'Ukázať') }}
        </p>
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
