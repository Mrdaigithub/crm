<template>
  <div>
    <div class="content-header"><h2>用户管理</h2></div>
    <el-row>
      <el-col :span="22" :offset="1">
        <br>
        <el-button type="primary" icon="plus" @click="handleAdd"> 添加用户</el-button>
        <el-dialog
          :title="userForm.addMode? '添加用户' : '用户资料编辑'"
          :visible.sync="userForm.visible"
          size="large"
          :close-on-press-escape="false">
          <el-form :model="userInfo" :rules="userRules" ref="userInfo" label-width="100px">
            <el-row>
              <el-col :span="20">
                <el-form-item label="管理组" prop="role">
                  <el-radio-group v-model="userInfo.roleName">
                    <el-radio
                      v-for="roleitem in roleList"
                      :key="roleitem['role_name']"
                      :label="roleitem['role_name']"></el-radio>
                  </el-radio-group>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row>
              <el-col :span="10">
                <el-form-item label="用户名" prop="username">
                  <el-input type="text" v-model="userInfo.username" auto-complete="off" placeholder="中英文皆可"></el-input>
                </el-form-item>
              </el-col>
              <el-col :span="10" :offset="1">
                <el-form-item :label="userForm.addMode ? '初始密码' : '密码'"
                              prop="password">
                  <el-input type="password"
                            v-model="userInfo.password"
                            placeholder="请输入4-16位密码"
                            auto-complete="off"></el-input>
                </el-form-item>
              </el-col>
            </el-row>
            <el-row>
              <el-col :span="10">
                <el-form-item label="电话号码" prop="tel">
                  <el-input v-model.number="userInfo.tel"></el-input>
                </el-form-item>
              </el-col>
            </el-row>
          </el-form>
          <div slot="footer" class="dialog-footer">
            <el-button type="primary" @click="handleAddSubmit" :disabled="btnState">确 定</el-button>
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
      var validateUsername = (rule, value, callback) => {
        if (value === '') return callback(new Error('请输入用户名'));
        if (!/^(?!_)(?!.*?_$)[a-zA-Z0-9_\u4e00-\u9fa5]+$/.test(value)) return callback(new Error('用户名不能包含非法字符'));
        callback();
      };
      var validatePassword = (rule, value, callback) => {
        if (value === '') return callback(new Error('请输入密码'));
        if (value.length < 4) return callback(new Error('密码长度过短'));
        if (value.length > 15) return callback(new Error('密码长度过长'));
        callback();
      };
      var validateTel = (rule, value, callback) => {
        if (!value) return callback(new Error('电话号码不能为空'));
        if (!Number.isInteger(value)) return callback(new Error('请输入数字值'));
        if (!/^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/.test(value)) return callback(new Error('电话号码格式不正确'));
        callback();
      };
      return {
        sUserData: [],
        roleList: [],
        userForm: {
          addMode: false,
          currRole: '',
          visible: false,
        },
        userInfo: {
          roleName: '',
          username: '',
          password: '',
          tel: ''
        },
        userRules: {
          username: [
            {validator: validateUsername, trigger: 'blur'}
          ],
          password: [
            {validator: validatePassword, trigger: 'blur'}
          ],
          tel: [
            {validator: validateTel, trigger: 'blur'}
          ]
        }
      }
    },
    computed: {
      btnState(){
        return (this.userInfo.username && this.userInfo.password && this.userInfo.tel) ? false : true;
      },
      userData(){
        return this.sUserData.map(e=>{
          if (e.state === '0') e.state = false;
          return e
        })
      }
    },
    methods: {
      handleAdd(){
        this.userForm.addMode = true;
        this.userForm.visible = true;
        let self = this;
      },
      handleAddSubmit(){
        this.$Progress.start();
        let self = this;
        !async function () {
          let newUser = (await axios.post('http://crm.mrdaisite.com/back_end/api/v1/user/', qs.stringify({
            token: localStorage.token,
            username: self.userInfo.username,
            password: self.userInfo.password,
            tel: self.userInfo.tel,
            role_name:self.userInfo.roleName
          }))).data;
          self.userForm.visible = false;
          self.sUserData.push(newUser);
          self.userInfo.username = '';
          self.userInfo.password = '';
          self.userInfo.tel = '';
          self.$Progress.finish();
        }()
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
        self.userForm.addMode = false;
        self.userForm.visible = true;
        self.userInfo.username = row.username;
        self.userInfo.password = '';
        self.userInfo.tel = '';
        console.log(row);
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
    },
    mounted(){
      let self = this;
      !async function () {
        self.sUserData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/user/?token=${localStorage.token}`)).data
        self.roleList = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/role/?token=${localStorage.token}`)).data
        self.userInfo.roleName = self.roleList[0]['role_name'];
      }()
    }
  }
</script>
<style scope lang="scss">
  .dialog-footer {
    .el-button {
      width: 100%;
    }
  }
</style>
