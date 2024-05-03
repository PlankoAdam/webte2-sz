<template>
  <div>
    <QRModal
      v-if="showQRmodal"
      @close="showQRmodal = false"
      :qrsrc="props.qrsrc"
      :code="props.code"
    ></QRModal>
    <div
      class="flex flex-row space-x-8 rounded-lg w-[32rem] p-4 text-[var(--prim400)] dark:text-[var(--prim500)] transition-all"
      :class="{
        active: props.active,
        'bg-[var(--prim200)] dark:bg-[var(--prim900)]': !props.active
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
  @apply text-[var(--prim950)] dark:text-[var(--prim050)];

  background-image: linear-gradient(180deg, var(--prim300), var(--prim400) 51%, var(--prim400));
  @media (prefers-color-scheme: dark) {
    color: var(--prim050);
    background-image: linear-gradient(180deg, var(--prim600), var(--prim700) 51%, var(--prim700));
  }
  background-position: 0 var(--y, 100%);
  background-size: 200% 200%;
}

.active:hover {
  --y: 0;
}

.active p {
  @apply text-[var(--prim950)] hover:bg-[var(--prim500)];
  @apply dark:text-[var(--prim050)] dark:hover:bg-[var(--prim500)];
}

div p {
  @apply px-2 rounded-md;
}

.activate-btn {
  @apply text-[var(--prim950)] hover:bg-[var(--prim400)];
  @apply dark:text-[var(--prim050)] dark:hover:bg-[var(--prim600)];
}
</style>
