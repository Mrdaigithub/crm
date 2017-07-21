import axios from 'axios'
import {Message} from 'element-ui'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
// const router = require('~router')

const errors = {
  400000: '权限组名称存在非法字符',
  400001: '权限组已存在',
  400002: '权限组ID仅为数字',
  400003: '权限组不存在',
  400004: '权限名称缺失',
  400005: '用户名缺失',
  400006: '用戶名过短',
  400007: '用戶名过长',
  400008: '用戶名存在非法字符',
  400009: '用户名已存在',
  400010: '密码缺失',
  400011: '密码过短',
  400012: '密码过长',
  400013: '密码存在非法字符',
  400014: '用户电话格式错误',
  400015: '用户头像图片url格式错误',
  400016: '用户ip格式错误',
  400017: '用户所属的权限组ID缺失',
  400018: '用户所属的权限组不存在',
  400019: '用户启用状态错误',
  400020: '用户不存在',
  401000: '用戶名缺失',
  401001: '密码缺失',
  401002: '用戶名过短',
  401003: '密码过短',
  401004: '用戶名过长',
  401005: '密码过长',
  401006: '用戶名存在非法字符',
  401007: '密码存在非法字符',
  401008: '用戶不存在',
  401009: '密码错误',
  500000: '网络错误',
  500001: '保存失败',
  500002: '无法删除存在子用户的权限组'
}

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
      let errorCode = error.response.data.message
      Message.error(errors[errorCode])
    }
    NProgress.done()
    return Promise.reject(error.response.data)
  })

export default axiosInstance
