import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useLanguageStore = defineStore('language', () => {
  const selectedLang = ref('en')

  const change = () => {
    if (selectedLang.value == 'en') selectedLang.value = 'sk'
    else if (selectedLang.value == 'sk') selectedLang.value = 'en'
  }

  const t = (entext, skText) => {
    if (selectedLang.value == 'sk') return skText
    else return entext
  }

  return { selectedLang, change, t }
})
