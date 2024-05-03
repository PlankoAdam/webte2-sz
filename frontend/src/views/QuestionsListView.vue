<template>
  <main class="flex justify-center">
    <div class="bg-[var(--color-bg-soft)] p-8 rounded-xl">
      <RouterLink to="/questions/create">
        <div class="create-new mb-16">
          <div class="plus-sign">
            <v-icon name="fa-plus" scale="4"></v-icon>
          </div>
          <div class="content-center text-3xl font-light">
            {{ langStore.t('Create new question', 'Vytvoriť novú otázku') }}
          </div>
        </div>
      </RouterLink>
      <div class="flex flex-col space-y-4">
        <QuestionListItem
          v-for="q in questions"
          :key="q.code"
          :code="q.code"
          :question="q.question"
          :qrsrc="q.qrsrc"
          :active="q.active"
        ></QuestionListItem>
      </div>
    </div>
  </main>
</template>

<script setup>
import { useLanguageStore } from '@/stores/language'
import QuestionListItem from '@/components/QuestionListItem.vue'
import { RouterLink } from 'vue-router'
import { ref } from 'vue'

const langStore = useLanguageStore()

const questions = ref([
  {
    code: 'abc12',
    question: 'Lorem ipsum?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: 'gdr34',
    question: 'Dolor sit amet?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: false
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  },
  {
    code: '1594f',
    question: 'Qsdohsdgsdf?',
    qrsrc: 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example',
    active: true
  }
])
</script>

<style scoped>
.create-new {
  @apply flex flex-row space-x-8 rounded-lg w-[32rem] p-4 transition-all duration-300 cursor-pointer;

  color: var(--prim950);
  background-image: linear-gradient(180deg, var(--prim300), var(--prim400) 51%, var(--prim400));
  @media (prefers-color-scheme: dark) {
    color: var(--prim050);
    background-image: linear-gradient(180deg, var(--prim600), var(--prim700) 51%, var(--prim700));
  }
  background-position: 0 var(--y, 100%);
  background-size: 200% 200%;
}

.create-new:hover {
  color: var(--prim950);
  @media (prefers-color-scheme: dark) {
    color: white;
  }
  @apply shadow-black shadow-lg;
  --y: 0;
}

/* .create-new:hover > .plus-sign {
  color: var(--prim400);
  @media (prefers-color-scheme: dark) {
    color: var(--prim600);
  }
} */

.plus-sign {
  background-color: var(--color-bg);

  color: var(--prim400);
  @media (prefers-color-scheme: dark) {
    color: var(--prim700);
  }

  @apply min-w-24 min-h-24 rounded-lg content-center text-center;
}
</style>
