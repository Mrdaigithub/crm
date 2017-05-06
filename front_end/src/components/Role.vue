<template>
  <div>
    <div class="content-header"><h2>权限组管理</h2></div>
    <el-row>
      <el-col :span="22" :offset="1">
        <br><br>
        <el-button type="primary" icon="plus" @click="handleAdd"> 添加用户组</el-button>
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
                  @change="handleToggle(scope.row)">
                </el-switch>
                <el-button
                  size="small"
                  @click="handleEdit(scope.row)"
                  icon="edit">编辑
                </el-button>
                <el-button
                  size="small"
                  type="danger"
                  @click="handleDelete(scope.$index, scope.row)"
                  icon="delete">删除
                </el-button>
                <el-button
                  size="small"
                  type="success"
                  @click="handlePermission(scope.$index, scope.row)"
                  icon="setting">分配权限
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
        loading: false,
        editingName: ''
      }
    },
    methods: {
      handleAdd(){
        let self = this;
        this.$prompt('添加用户组', {
          showCancelButton: false,
          confirmButtonText: '添加',
        }).then(({value}) => {
          this.$Progress.start();
          !async function () {
            await axios.post('http://crm.mrdaisite.com/back_end/api/v1/role/', qs.stringify({
              token: localStorage.token,
              new_role_name: value
            }));
            self.roleData.push({
              name:value,
              state:false,
              fixed:false
            })
            self.$Progress.finish();
          }()
        }).catch(() => {
        });
      },
      handleToggle(row){
        let self = this;
        this.$Progress.start();
        !async function () {
          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/', qs.stringify({
            token: localStorage.token,
            role_name: row.name,
            state: row.state
          }));
          self.$Progress.finish();
        }()
      },
      handleEdit(row) {
        let self = this;
        this.editingName = row.name
        this.$prompt('修改组名', {
          showCancelButton: false,
          inputValue: this.editingName,
          confirmButtonText: '添加',
        }).then(({value}) => {
          this.$Progress.start();
          !async function () {
            await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/name/', qs.stringify({
              token: localStorage.token,
              old_role_name: row.name,
              new_role_name: value
            }))
            row.name = value;
            self.$Progress.finish();
          }()
        }).catch(() => {
        });
      },
      handleDelete(index, row) {
        let self = this;
        console.log(index, row.name)
        self.$Progress.start();
        !async function () {
          await axios.delete('http://crm.mrdaisite.com/back_end/api/v1/role/', {
            data: qs.stringify({
              token: localStorage.token,
              role_name: row.name
            })
          })
          self.roleData.splice(index, 1);
          self.$Progress.finish();
        }()
      }
    },
    mounted(){
      let self = this;
      !async function () {
        self.roleData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/role/?token=${localStorage.token}`)).data
        self.roleData = self.roleData.map(e => {
          e.state = e.state == 1;
          return e
        })
      }()
    }
  }
</script>

<style spoce lang="scss">
</style>
