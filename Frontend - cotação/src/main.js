import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import VueToast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'

Vue.config.productionTip = false

Vue.use(VueToast, {
  position: 'top-right'
});


new Vue({
  router,
  render: function (h) { return h(App) }
}).$mount('#app')
