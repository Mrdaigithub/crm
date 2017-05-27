import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import ElementUI from 'element-ui'
import '../node_modules/element-ui/lib/theme-default/index.css'
import VueProgressBar from 'vue-progressbar'

const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '3px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.config.productionTip = false;
Vue.use(ElementUI)
Vue.use(VueProgressBar, options)

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App}
})
