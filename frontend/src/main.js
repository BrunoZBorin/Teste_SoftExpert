import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap/dist/js/bootstrap.js'
import './assets/main.css'
import VueTheMask from 'vue-the-mask'

const app = createApp(App)

app.use(VueTheMask)
app.use(router)

app.mount('#app')
