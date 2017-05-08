<template>
  <div>
    <div class="content-header"><h2>用户管理</h2></div>
    <el-row>
      <el-col :span="22" :offset="1">
        <br>
        <el-button type="primary" icon="plus" @click="handleAdd"> 添加用户</el-button>
        <el-dialog
          title="添加用户"
          :visible.sync="dialogFormVisible">
          <el-form :model="form">
            <el-row>
              <el-col :span="24">
                <el-form-item label="权限组：" :label-width="formLabelWidth">
                  <el-radio-group v-model="form.resource">
                    <el-row>
                      <el-col :span="8"><el-radio label="root"></el-radio></el-col>
                      <el-col :span="8"><el-radio label="admin1"></el-radio></el-col>
                      <el-col :span="8"><el-radio label="admin2"></el-radio></el-col>
                      <el-col :span="8"><el-radio label="admin3"></el-radio></el-col>
                      <el-col :span="8"><el-radio label="admin4"></el-radio></el-col>
                    </el-row>
                  </el-radio-group>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row>
              <el-col :span="11">
                <el-form-item label="用户名：" :label-width="formLabelWidth">
                  <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="11">
                <el-form-item label="初始密码：" :label-width="formLabelWidth">
                  <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row>
              <el-col :span="11">
                <el-form-item label="手机号：" :label-width="formLabelWidth">
                  <el-input v-model="form.name" auto-complete="off"></el-input>
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button type="primary" @click="dialogFormVisible = false">确 定</el-button>
          </div>
        </el-dialog>
        <br><br>
        <el-table
          :data="userData"
          border
          class="m-content">
          <el-table-column
            prop="id"
            label="ID"
            width="80">
          </el-table-column>
          <el-table-column
            prop="username"
            label="用户名"
            width="100">
          </el-table-column>
          <el-table-column
            prop="role_name"
            label="用户组"
            width="150">
          </el-table-column>
          <el-table-column
            label="操作">
            <template scope="scope">
              <el-button
                size="small"
                @click="handleEdit(scope.row)"
                icon="edit">修改
              </el-button>
              <el-button
                size="small"
                type="danger"
                @click="handleDelete(scope.$index, scope.row)"
                icon="delete">删除
              </el-button>
              <el-switch
                v-model="scope.row.state"
                on-color="#13ce66"
                off-color="#ff4949"
                on-text="启用"
                off-text="禁用"
                @change="handleToggle(scope.row)">
              </el-switch>
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
    name: 'user',
    data() {
      return {
        userData: [],
        loading: false,
        editingName: '',
        dialogFormVisible: false,
        form: {
          name: '',
          region: '',
          date1: '',
          date2: '',
          delivery: false,
          type: [],
          resource: '',
          desc: ''
        },
        formLabelWidth: '100px'
      }
    },
    methods: {
      handleAdd(){
        let self = this;
        this.dialogFormVisible = true;
      },
      handleToggle(row){
        let self = this;
        this.$Progress.start();
        !async function () {
          await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/user/state/', qs.stringify({
            token: localStorage.token,
            username: row.username,
            state: row.state
          }));
          self.$Progress.finish();
        }()
      },
      handleEdit(row) {
        let self = this;
        console.log(row)
        this.editingName = row.name
        this.$prompt(`${this.editingName}修改组名`, {
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
        self.$Progress.start();
        !async function () {
          await axios.delete('http://crm.mrdaisite.com/back_end/api/v1/user/', {
            data: qs.stringify({
              token: localStorage.token,
              username: row.username
            })
          })
          self.userData.splice(index, 1);
          self.$Progress.finish();
        }()
      },
      handlePermission(index, row){
        this.$router.push({ name: 'permission', params: { RoleName: row.name }})
      }
    },
    mounted(){
      let self = this;
      !async function () {
        self.userData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/user/?token=${localStorage.token}`)).data
        self.userData.forEach(e=>{
            if (e.state === '0') e.state = false;
        })
      }()
    }
  }
</script>
