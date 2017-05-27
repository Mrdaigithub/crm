import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Login from '@/components/Login'
import Patient from '@/components/Patient'
import Doctor from '@/components/Doctor'
import Role from '@/components/Role'
import Permission from '@/components/Permission'
import User from '@/components/User'
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
        {path: '/system_role', name: 'role', component: Role},
        {path: '/system_permission', name: 'permission', component: Permission},
        {path: '/system_user', name: 'user', component: User},
        {path: '/system_log', name: 'log', component: Log}
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    }
  ]
})
