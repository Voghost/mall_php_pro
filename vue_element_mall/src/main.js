import Vue from 'vue'
import App from './App.vue'
import qs from 'qs'
import api from '@/api/index'

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import store from './store'
import router from './router'

Vue.use(ElementUI)
Vue.use(qs)

Vue.prototype.$api = api;


Vue.config.productionTip = false

new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app')
