<template>
  <QRModal
    v-if="showModal"
    @close="showModal = false"
    :qrsrc="data.qrsrc"
    :code="data.code"
  ></QRModal>
  <main
    class="mt-[var(--nav-h)] lg:mt-0 bg-[var(--color-bg)] fixed top-0 bottom-0 overflow-y-scroll lg:relative lg:ms-[28rem] z-10 w-full lg:h-full h-[100vh]"
  >
    <div class="flex flex-col items-center p-8">
      <div class="flex flex-col mb-16">
        <div
          @click="showModal = true"
          class="size-fit bg-white p-2 rounded-md mb-2 hover:cursor-pointer"
        >
          <img :src="data.qrsrc" alt="QR code" class="size-96" />
        </div>
        <h1 class="text-center text-4xl text-[var(--color-heading)] font-mono font-bold">
          {{ $route.params.id }}
        </h1>
      </div>
      <div class="flex flex-col">
        <h1 class="text-6xl font-light mb-8">{{ data.question }}</h1>
        <ul class="flex flex-col space-y-2">
          <li
            v-for="ans in data.answers"
            :key="ans"
            class="p-1 px-4 rounded-sm bg-[var(--color-bg-soft)]"
          >
            {{ ans }}
          </li>
        </ul>
      </div>
    </div>
  </main>
</template>

<script setup>
import QRModal from '@/components/QRModal.vue'
import { watch } from 'vue'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
// TODO get data from server

const route = useRoute()

const dummyData = {
  code: route.params.id,
  question: 'Lorem ipsum?',
  qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
  active: true,
  answers: ['ans1', 'ans2', 'ans3']
}

// TODO update data on route change
watch(
  () => route.params.id,
  (newId) => (dummyData.code = newId)
)

const data = ref(dummyData)
const showModal = ref(false)
</script>
