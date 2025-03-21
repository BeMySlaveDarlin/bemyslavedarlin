import "@/assets/index.css"

import {createApp} from "vue"
import {createPinia} from "pinia"
import piniaPluginPersistedState from "pinia-plugin-persistedstate"
import App from "./components/Index.vue"

const app = createApp(App)
const pinia = createPinia()

pinia.use(piniaPluginPersistedState)
app.use(pinia)

app.mount('#app')
