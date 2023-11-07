import './plugins/base'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import validationRules from "./plugins/validateRules.js";
import route from './routes/index.js'
import { store } from "@/stores/index.js";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
Vue.config.productionTip = false
Vue.use(Toast);
new Vue({
  vuetify,
  validationRules,
  router: route,
  store,
  render: h => h(App)
}).$mount('#app')
