import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import ElementUI from 'element-ui'
import '../node_modules/element-ui/lib/theme-default/index.css'
import VueProgressBar from 'vue-progressbar'

Vue.config.productionTip = false;
Vue.use(ElementUI)
Vue.use(VueProgressBar, {
  color: '#fff',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
})

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App}
})
