<template>
  <div>
    <div class="content-header"><h2>权限组管理</h2></div>
    <el-row>
      <el-col :span="22" :offset="1">
        <br>
        <el-button type="primary" icon="plus" @click="handleAdd"> 添加用户组</el-button>
        <br><br>
        <el-table
          :data="roleData"
          border
          class="m-content">
          <el-table-column
            prop="role_name"
            label="用户组名"
            width="250">
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
            await axios.post('http://crm.mrdaisite.com/api/v1/role/', qs.stringify({
              token: localStorage.token,
              new_role_name: value
            }));
            self.roleData.push({
              role_name:value,
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
            role_name: row['role_name'],
            state: row.state
          }));
          self.$Progress.finish();
        }()
      },
      handleEdit(row) {
        let self = this;
        this.editingName = row['role_name'];
        this.$prompt('修改组名', {
          showCancelButton: false,
          inputValue: this.editingName,
          confirmButtonText: '添加',
        }).then(({value}) => {
          this.$Progress.start();
          !async function () {
            await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/role/name/', qs.stringify({
              token: localStorage.token,
              old_role_name: row['role_name'],
              new_role_name: value
            }))
            row['role_name'] = value;
            self.$Progress.finish();
          }()
        }).catch(() => {
        });
      },
      handleDelete(index, row) {
        let self = this;
        self.$Progress.start();
        !async function () {
          await axios.delete('http://crm.mrdaisite.com/back_end/api/v1/role/', {
            data: qs.stringify({
              token: localStorage.token,
              role_name: row['role_name']
            })
          })
          self.roleData.splice(index, 1);
          self.$Progress.finish();
        }()
      },
      handlePermission(index, row){
          this.$router.push({ name: 'permission', params: { RoleName: row['role_name'] }})
      }
    },
    mounted(){
      let self = this;
      !async function () {
        self.roleData = (await axios.get(`http://crm.mrdaisite.com/api/v1/role/?token=${localStorage.token}`)).data
        self.roleData = self.roleData.map(e => {
          e.state = e.state == 1;
          return e
        })
      }()
    }
  }
</script>
