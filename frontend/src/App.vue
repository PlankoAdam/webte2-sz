<template>
  <nav class="h-[var(--nav-h)] w-full fixed top-0 left-0 bg-[var(--color-bg)] z-20">
    <div
      class="lg:hidden relative w-full h-full flex flex-row items-center justify-between z-20 px-8"
    >
      <div
        v-if="$route.name != 'home'"
        class="text-3xl text-center font-light text-[var(--color-heading)] select-none cursor-pointer"
        @click="$router.push('/')"
      >
        interact<span class="text-[var(--acc500)] dark:text-[var(--acc400)]">ED</span>
      </div>
      <div v-else></div>
      <v-icon
        name="fa-bars"
        scale="2"
        @click="showMobileMenu = !showMobileMenu"
        class="transition-all"
        :class="{ 'rotate-90': showMobileMenu }"
      ></v-icon>
    </div>
    <div
      @click="showMobileMenu = false"
      :style="`--menu-y:${showMobileMenu ? 0 : -100}%`"
      class="translate-y-[var(--menu-y)] transition-transform duration-500 lg:translate-y-0 flex flex-col lg:px-16 justify-center items-center absolute top-0 left-0 w-[100vw] h-[100vh] z-10 bg-[var(--color-bg)] lg:relative lg:flex-row lg:grid lg:grid-cols-2 lg:h-full content-center"
    >
      <div
        class="flex flex-col lg:flex-row text-3xl mb-8 pb-8 lg:p-0 lg:m-0 border-b-2 border-[var(--color-bg-mute)] lg:border-none min-w-64 text-center lg:mb-0 space-y-8 lg:space-y-0 lg:space-x-8"
      >
        <RouterLink
          to="/"
          class="inline-block hover:text-[var(--color-heading)] hover:tracking-widest transition-all"
          >{{ langStore.t('Home', 'Domov') }}</RouterLink
        >
        <RouterLink
          v-if="userStore.isLoggedIn()"
          to="/questions"
          class="inline-block hover:text-[var(--color-heading)] hover:tracking-widest transition-all"
          >{{ langStore.t('Questions', 'Otázky') }}</RouterLink
        >
        <RouterLink
          v-if="userStore.user.admin"
          to="/users"
          class="inline-block hover:text-[var(--color-heading)] hover:tracking-widest transition-all"
          >{{ langStore.t('Users', 'Používatelia') }}</RouterLink
        >
      </div>
      <div
        class="flex lg:flex-row flex-col justify-end space-y-8 lg:space-y-0 lg:space-x-6 items-center lg:items-end"
      >
        <RouterLink
          v-if="userStore.isLoggedIn()"
          to="/dashboard/profile"
          class="min-w-8 text-center cursor-pointer uppercase hover:scale-105 transition-all"
        >
          {{ userStore.user.name }}
        </RouterLink>
        <RouterLink
          v-if="!userStore.isLoggedIn()"
          to="/login"
          class="inline-block uppercase hover:scale-105 transition-all"
          >{{ langStore.t('log in', 'prihlásenie') }}</RouterLink
        >
        <h1
          v-if="userStore.isLoggedIn()"
          @click="userStore.logout"
          class="min-w-8 text-center cursor-pointer uppercase hover:scale-105 transition-all"
        >
          {{ langStore.t('log out', 'odhlásiť sa') }}
        </h1>
        <h1
          @click="langStore.change"
          class="min-w-8 text-center cursor-pointer uppercase hover:scale-105 transition-all"
        >
          {{ langStore.t('sk', 'en') }}
        </h1>
      </div>
    </div>
  </nav>

  <div>
    <RouterView />
  </div>
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
import { useLanguageStore } from '@/stores/language'
import { useUserStore } from '@/stores/user'
import { ref } from 'vue'

const langStore = useLanguageStore()
const userStore = useUserStore()

const showMobileMenu = ref(false)
</script>
