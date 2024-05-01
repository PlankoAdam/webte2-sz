<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <nav
    class="h-16 w-full bg-slate-950 fixed top-0 left-0 px-8 text-2xl content-center border-b-2 border-slate-700"
  >
    <RouterLink class="text-slate-300 hover:text-slate-50 transition-all" to="/">Home</RouterLink>
  </nav>

  <div class="mt-16">
    <RouterView />
  </div>
</template>
