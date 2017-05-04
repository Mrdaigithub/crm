<template>
  <div>
    <h1>role</h1>
    <Table border :context="self" :columns="roleCol" :data="roleData"></Table>
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'role',
    data () {
      return {
        self: this,
        roleCol: [
          {
            title: '用户组名',
            key: 'name',
            render (row, column, index) {
              return `<Icon type="person"></Icon> <strong>${row.name}</strong>`;
            }
          },
          {
            title: '操作',
            key: 'action',
            width: 300,
            align: 'center',
            render (row, column, index) {
              return parseInt(row.fixed) ? `<i-button :type="roleData[${index}].state? 'primary' : 'error'" size="small" @click="toggleState(${index})">启用</i-button> <i-button type="error" size="small" @click="remove(${index})">删除</i-button>` : `无权操作`;
            }
          }
        ],
        roleData: []
      }
    },
    methods: {
      toggleState(index){
          let self = this
        this.roleData[index].state = !this.roleData[index].state
        !async function () {
          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/', qs.stringify({token: localStorage.token,role_name:self.roleData[index].name}))
        }()
      },
      show (index) {
        this.$Modal.info({
          title: '用户信息',
          content: `姓名：${this.roleData[index].name}<br>年龄：${this.roleData[index].age}<br>地址：${this.roleData[index].address}`
        })
      },
      remove (index) {
        this.roleData.splice(index, 1);
      }
    },
    mounted(){
      let self = this
      !async function () {
        self.roleData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/role/?token=${localStorage.token}`)).data
      }()
    }
  }
</script>
<style>
</style>
