import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { plugin, defaultConfig } from '@formkit/vue'

import { OhVueIcon, addIcons } from 'oh-vue-icons'
import { FaPlus, FaMinus, FaRegularUserCircle, FaTrash, FaEdit, FaCheck } from 'oh-vue-icons/icons'

addIcons(FaPlus, FaMinus, FaRegularUserCircle, FaTrash, FaEdit, FaCheck)

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(plugin, defaultConfig)
app.component('v-icon', OhVueIcon)

app.mount('#app')
