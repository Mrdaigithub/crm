import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Login from '@/components/Login'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

Vue.use(Router)

const router = new Router({
  routes: [
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/home',
      name: 'home',
      component: Home
    }
  ]
})


router.beforeEach((to, from, next) => {
  NProgress.start();
  if (!localStorage.token && to.name !== 'login') next('login');
  next();
})

router.afterEach(route => {
  NProgress.done();
})

export default router;
