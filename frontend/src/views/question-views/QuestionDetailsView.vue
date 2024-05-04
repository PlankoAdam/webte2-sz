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
    <div class="flex flex-col xl:flex-row xl:space-x-20 xl:justify-center items-center p-8">
      <div class="flex flex-col items-center mb-16 xl:m-0">
        <div
          @click="
            () => {
              if (data.active) showModal = true
            }
          "
          class="size-fit bg-white p-2 rounded-md mb-2 transition-all ease-out"
          :class="{
            'hover:cursor-pointer hover:scale-110': data.active,
            'opacity-40': !data.active
          }"
        >
          <img :src="data.qrsrc" alt="QR code" class="size-full" />
        </div>
        <h1
          class="text-center text-4xl font-mono font-bold transition-colors"
          :class="{
            'text-[var(--color-heading)]': data.active,
            'text-[var(--color-bg-mute)]': !data.active
          }"
        >
          {{ data.code }}
        </h1>
        <div class="flex flex-row xl:flex-col justify-center space-x-2 xl:space-x-0 w-full">
          <button @click="data.active = !data.active">
            {{ data.active ? 'Deactivate' : 'Activate' }}
          </button>
          <button @click="$router.push(`/questions/edit/${data.code}`)">{{ 'Edit' }}</button>
          <button class="btn-danger">{{ 'Delete' }}</button>
        </div>
      </div>
      <div class="flex flex-col">
        <h1 class="text-6xl font-light mb-8 max-w-[32rem] min-w-fit">{{ data.question }}</h1>
        <ul class="flex flex-col space-y-2 max-w-96">
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
  question: 'Is this a really long question for testing?',
  qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
  active: false,
  answers: ['answer 1', 'ans2', 'ans3']
}

// TODO update data on route change
watch(
  () => route.params.id,
  (newId) => (dummyData.code = newId)
)

const data = ref(dummyData)
const showModal = ref(false)
</script>

<style scoped>
button {
  background-color: var(--color-bg-soft);
  color: var(--color-text);
  border: none;
  @apply p-1 w-24 xl:w-full;
}

button:hover {
  background-color: var(--color-bg-mute);
  color: var(--color-heading);
}
</style>
