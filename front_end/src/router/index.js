import Vue from 'vue'
import Router from 'vue-router'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

import Home from '@/components/Home'
import Login from '@/components/Login'
import Console from '@/components/Console'
import Rank from '@/components/Rank'
import Patient from '@/components/Patient'
import User from '@/components/User'

import DiseasesManagement from '@/components/management/Diseases'
import DoctorsManagement from '@/components/management/Doctors'
import ChannelManagement from '@/components/management/Channel'


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
        {path: '/home/console', name: 'console', component: Console},
        {path: '/home/rank', name: 'rank', component: Rank},
        {path: '/home/patient', name: 'patient', component: Patient},
        {path: '/home/users', name: 'user', component: User},

        {path: '/management/diseases', name: 'diseasesManagement', component: DiseasesManagement},
        {path: '/management/doctors', name: 'DoctorsManagement', component: DoctorsManagement},
        {path: '/management/channel', name: 'channelManagement', component: ChannelManagement},
      ]
    }
  ]
})


router.beforeEach((to, from, next) => {
  NProgress.start();
  next();
})

router.afterEach(route => {
  if (!sessionStorage.token && route.name !== 'login') router.replace('/login');
  if (sessionStorage.token && route.name === 'home') router.replace('/home/console');
  NProgress.done();
})

export default router;
