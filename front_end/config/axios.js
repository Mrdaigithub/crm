import axios from 'axios'
import {Message} from 'element-ui'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
const router = require('~router')

let axiosInstance = axios.create({
  baseURL: 'http://crm.mrdaisite.com/api',
  timeout: 3000,
  headers: {'Content-Type': 'application/x-www-form-urlencoded'}
})

axiosInstance.interceptors.request.use(
  config => {
    NProgress.start()
    if (sessionStorage.token) {
      config.headers.common['Authorization'] = `Bearer ${sessionStorage.token}`
    }
    return config
  },
  err => {
    Message.error({
      message: 'Internal Error'
    })
    NProgress.done()
    return Promise.reject(err)
  })

axiosInstance.interceptors.response.use(
  response => {
    // if (response.headers.authorization) sessionStorage.token = response.headers.authorization.replace(/Bearer\s/,'');
    NProgress.done()
    return response.data
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 400:
          Message.error({message: 'BadRequest'})
          break
        case 401:
          Message.error({message: 'Unauthorized'})
          console.log(router)
          break
        case 403:
          Message.error({message: 'Forbidden'})
          break
        case 405:
          Message.error({message: 'MethodNotAllowed'})
          break
        case 500:
          Message.error({message: 'Internal Error'})
          break
      }
    }
    NProgress.done()
    return Promise.reject(error.response.data)
  })

export default axiosInstance
