import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import iView from 'iview'
import '../node_modules/iview/dist/styles/iview.css'

Vue.config.productionTip = false

Vue.use(iView)

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})

router.beforeEach((to, from, next) => {
  iView.LoadingBar.start();
  next();
});

router.afterEach((to, from, next) => {
  iView.LoadingBar.finish();
});
