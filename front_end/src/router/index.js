import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Patient from '@/components/Patient'
import Doctor from '@/components/Doctor'
import Log from '@/components/Log'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/home',
      name: 'home',
      component: Home,
      children:[
        {path: '/patients_regsiter', name: 'patient', component: Patient},
        {path: '/info_doctor', name: 'doctor', component: Doctor},
        {path: '/system_log', name: 'Log', component: Log}
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
  ]
})
