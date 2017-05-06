<template>
  <div>
    <div class="content-header"><h2>权限组管理</h2></div>
    <el-row>
      <el-col :span="22" :offset="1">
        <br><br>
        <el-button type="primary" icon="plus"> 添加用户组</el-button>
        <br><br>
        <el-table
          :data="roleData"
          border
          class="m-content"
          v-loading.fullscreen.lock="loading"
          element-loading-text="拼命加载中">
          <el-table-column
            label="用户组名"
            width="250">
            <template scope="scope">
              <el-popover trigger="hover" placement="top">
                <p>用户组名: {{ scope.row.name }}</p>
                <div slot="reference">
                  <el-tag>{{ scope.row.name }}</el-tag>
                </div>
              </el-popover>
            </template>
          </el-table-column>
          <el-table-column label="操作">
            <template scope="scope">
              <div v-if="!!parseInt(scope.row.fixed)">没有权限</div>
              <div v-else>
                <el-switch
                  v-model="scope.row.state"
                  on-color="#13ce66"
                  off-color="#ff4949"
                  on-text="启用"
                  off-text="禁用"
                  @change="handleToggle(scope.$index, scope.row)">
                </el-switch>
                <el-button
                  size="small"
                  @click="handleEdit(scope.$index, scope.row)">编辑
                </el-button>
                <el-button
                  size="small"
                  type="danger"
                  @click="handleDelete(scope.$index, scope.row)">删除
                </el-button>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'role',
    data() {
      return {
        roleData: [],
        loading:false
      }
    },
    methods: {
      handleToggle(index, row){
        this.$Progress.start()
        let self = this
        !async function () {
          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/', qs.stringify({
            token: localStorage.token,
            role_name: row.name,
            state: row.state
          }));
          self.$Progress.finish()
        }()
      },
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        console.log(index, row);
      }
    },
    mounted(){
      this.$Progress.start()
      console.log(this.$Progress)
      let self = this
      !async function () {
        self.roleData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/role/?token=${localStorage.token}`)).data
        self.roleData = self.roleData.map(e => {
          e.state = e.state === '0' ? false : true
          return e
        })
      }()
    }





//    data () {
//      return {
//        switch1: true,
//        self: this,
//        editNameModal: false,
//        roleName: '',
//        roleCol: [
//          {
//            title: '用户组名',
//            key: 'name',
//            render (row, column, index) {
//              return `<Icon type="person-stalker"></Icon> <strong>${row.name}</strong>`;
//            }
//          },
//          {
//            title: '操作',
//            key: 'action',
//            width: 600,
//            align: 'center',
//            render (row, column, index) {
//              return parseInt(row.fixed) ?
//                `无权操作` :
//                `<i-switch size="large" v-model="roleData[${index}].state" @on-change="toggleRoleState(${index})">
//                    <span slot="open">启用</span>
//                    <span slot="close">禁用</span>
//                </i-switch>
//
//                <i-button type="warning" size="small" @click="editRoleName(${index})"><Icon type="edit"></Icon> 修改</i-button>
//                <Modal
//                    v-model="editNameModal"
//                    title="修改组名"
//                    @on-ok="editRoleNameOk(${index})">
//                    用户组名:&nbsp;&nbsp;&nbsp;&nbsp;
//                    <i-input style="width: 250px" v-model="roleName"></i-input>
//                </Modal>
//
//                <i-button type="error" size="small" @click="remove(${index})"><Icon type="trash-b"></Icon> 删除</i-button>`;
//            }
//          }
//        ],
//        roleData: []
//      }
//    },
//    methods: {
//      toggleRoleState(index){
//        let self = this
//        !async function () {
//          self.$Loading.start();
//          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/', qs.stringify({
//            token: localStorage.token,
//            role_name: self.roleData[index].name,
//            state: self.roleData[index].state
//          }))
//          self.$Loading.finish();
//        }()
//      },
//      editRoleName(index){
//        this.editNameModal = true
//        this.roleName = this.roleData[index].name
//      },
//      editRoleNameOk(index){
//        let self = this
//        console.log(this.roleData[index].name)
//        let oldRoleName = this.roleData[index].name
//        !async function () {
//          self.$Loading.start();
//          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/name/', qs.stringify({
//            token: localStorage.token,
//            old_role_name: self.roleData[index].name,
//            new_role_name: self.roleName
//          }))
//          self.roleData[index].name = self.roleName
//          self.$Loading.finish();
//        }()
//      },
//      remove (index) {
//        let self = this
//        console.log(self.roleData[index].name)
//        !async function () {
//          self.$Loading.start();
//          await axios.delete('http://crm.mrdaisite.com/back_end/api/v1/role/', {
//              data:qs.stringify({
//                token: localStorage.token,
//                role_name: self.roleData[index].name
//              })
//          })
//          self.roleData.splice(index, 1);
//          self.$Loading.finish();
//        }()
//      },
//    },
//    mounted(){
//      let self = this
//      !async function () {
//        self.roleData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/role/?token=${localStorage.token}`)).data
//        self.roleData = self.roleData.map(e => {
//          e.state = e.state === '0' ? false : true
//          return e
//        })
//      }()
//    }
  }
</script>

<style spoce lang="scss">
</style>
