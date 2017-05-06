<template>
  <div>
    <h1>permission</h1>
    <Tree :data="permissionData" show-checkbox></Tree>
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'permission',
    data () {
      return {
        permissionData: [
          {
            "title": "系统后台",
            "children": [
              {
                "title": "控制台",
                "expand": true
              },
              {
                "title": "排行",
                "expand": true
              }
            ],
            "expand": true
          },
          {
            "id": "4",
            "title": "客户信息查看编辑操作",
            "level": "1",
            "children": [
              {
                "id": "21",
                "title": "允许编辑TA人登记信息",
                "level": "2",
                "expand": true
              },
              {
                "id": "22",
                "title": "允许新增客户信息",
                "level": "2",
                "expand": true
              },
            ],
            "expand": true
          },
          {
            "title": "系统设置",
            "children": [
              {
                "title": "权限组管理",
              },
              {
                "title": "用户列表",
              },
              {
                "title": "行为日志",
              },
              {
                "title": "通知管理",
              },
              {
                "title": "参数设置",
              }
            ],
            "expand": true
          }
        ]
      }
    },
    mounted(){
      let self = this
      !async function () {
        self.permissionData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/permission/?token=${localStorage.token}`)).data
        console.log(self.permissionData);
      }()
    }
  }
</script>
<style>
</style>
