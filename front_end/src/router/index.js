import Vue from 'vue'
import Router from 'vue-router'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Welcome from '@/components/Welcome'
import Rank from '@/components/Rank'
import Patient from '@/components/Patient'
import User from '@/components/User'

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
      component: Home,
      children: [
        {path: '/home/welcome', name: 'welcome', component: Welcome},
        {path: '/home/rank', name: 'rank', component: Rank},
        {path: '/home/patient', name: 'patient', component: Patient},
        {path: '/home/users', name: 'user', component: User},
      ]
    }
  ]
})


router.beforeEach((to, from, next) => {
  NProgress.start();
  next();
})

router.afterEach(route => {
  if (!localStorage.token && route.name !== 'login') router.replace('/login');
  if (localStorage.token && route.name === 'home') router.replace('/home/welcome');
  NProgress.done();
})

export default router;
