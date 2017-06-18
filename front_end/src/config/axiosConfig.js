import axios from 'axios'
import { Message } from 'element-ui';

let axiosInstance = axios.create({
  baseURL: 'http://crm.mrdaisite.com/api',
  timeout: 3000,
  headers: {'Content-Type': 'application/x-www-form-urlencoded'}
})

axiosInstance.interceptors.request.use(
  config => {
    if (localStorage.token) config.headers.common.Authorization = localStorage.token;
    return config;
  },
  err => {
    Message.error({
      message:'Internal Error'
    })
    return Promise.reject(err);
  });

axiosInstance.interceptors.response.use(
  response => {
    return response.data
  },
  error => {
    if (error.response) {
      switch (error.response.status) {
        case 400:Message.error({message:'BadRequest'});break;
        case 401:Message.error({message:'Unauthorized'});break;
        case 403:Message.error({message:'Forbidden'});break;
        case 405:Message.error({message:'MethodNotAllowed'});break;
        case 500:Message.error({message:'Internal Error'});break;
      }
    }
    return Promise.reject(error.response.data)   // 返回接口返回的错误信息
  });


export default axiosInstance;
