<template>
  <div class="user">
    <el-row>
      <el-col :span="6" class="role-area">
        <el-card class="box-card">
          <div slot="header" class="clearfix role-header">
            <span style="line-height: 36px;" @click="currentRoleId = 'all'">
              All users<el-badge class="mark" :value="users.length"/>
            </span>
          </div>
          <div class="role-item-title">Role</div>
          <div v-for="role in roles" class="role-item" :key="role.id" @click="currentRoleId = role.id">
            {{role.name}}
            <el-badge class="mark" :value="getRoleUserLength(role.id)"/>
          </div>
          <hr>
          <div class="add-role" @click="addRole">Add new role</div>
        </el-card>
      </el-col>
      <el-col :span="18" class="user-area">
        <el-card class="box-card">
          <h2>User List</h2>
          <el-button type="success" icon="plus" class="add_btn" @click="initUserFormData('new')"></el-button>
          <el-table :data="showUsersData" border style="width: 100%">
            <el-table-column prop="id" label="id" width="70"></el-table-column>
            <el-table-column prop="username" label="username" width="120"></el-table-column>
            <el-table-column prop="tel" label="tel" width="120"></el-table-column>
            <el-table-column prop="created_at" label="created_at" width="190"></el-table-column>
            <el-table-column prop="updated_at" label="updated_at" width="190"></el-table-column>
            <el-table-column prop="ip" label="ip" width="150"></el-table-column>
            <el-table-column label="tools" width="120" fixed="right">
              <template scope="scope">
                <el-button
                  size="small"
                  @click="initUserFormData('edit', scope.$index, scope.row)" icon="edit"></el-button>
                <el-button
                  size="small"
                  type="danger"
                  @click="removeUser(scope.$index, scope.row)" icon="delete"></el-button>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
    <el-dialog title="Edit user info" :visible.sync="dialogVisible" size="small">
      <el-form :model="userFormData.data" :rules="userFormData.rules" ref="userFormData" label-width="100px"
               class="new-user">
        <el-form-item label="username" prop="username">
          <el-input v-model="userFormData.data.username"></el-input>
        </el-form-item>
        <el-form-item label="password" prop="password">
          <el-input v-model="userFormData.data.password"></el-input>
        </el-form-item>
        <el-form-item label="tel" prop="tel">
          <el-input v-model="userFormData.data.tel"></el-input>
        </el-form-item>
        <el-form-item label="state" prop="state">
          <el-switch on-text="" off-text="" v-model="userFormData.data.state"></el-switch>
        </el-form-item>
        <el-form-item label="role" prop="role">
          <el-radio-group v-model="userFormData.data.role">
            <el-radio v-for="role in roles" key="role.id" :label="role.id.toString()">{{role.name}}</el-radio>
          </el-radio-group>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button type="primary" @click="saveUser('userFormData')" style="width: 100%">S a v e</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
  import axios from '../config/axiosConfig'
  import qs from 'qs'

  export default {
    name: 'user',
    data(){
      return {
        roles: [],
        users: [],
        currentRoleId: 'all',
        dialogVisible: false,
        userFormData: {
          data: {
            username: '',
            password: '',
            tel: '',
            state: false,
            role: ''
          },
          rules: {
            username: [
              {required: true, message: 'please enter username', trigger: 'blur'},
              {min: 4, max: 15, message: '4 to 15', trigger: 'blur'}
            ],
            password: [
              {min: 4, max: 15, message: '4 to 15', trigger: 'change'}
            ],
            tel: [
              {
                pattern: /^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/,
                message: 'pattern error',
                trigger: 'change'
              }
            ],
            role: [{required: true, message: 'please select a role', trigger: 'blur'}]
          }
        }
      }
    },
    computed: {
      showUsersData(){
        let showUsersData = [];
        if (this.currentRoleId === 'all') return this.users;
        else {
          for (let user of this.users) {
            if (this.currentRoleId === user['roles'][0]['id']) {
              showUsersData.push(user);
            }
          }
          return showUsersData
        }
      }
    },
    methods: {
      getRoleUserLength(roleId){
        let self = this;
        let len = 0;
        for (let user of self.users) {
          if (user['roles'][0]['id'] === roleId) len++;
        }
        return len
      },
      addRole(){
        let self = this;
        this.$prompt('Please enter a role name', 'Tips')
          .then(({value}) => {
            axios.get(`/roles/${value}/create`)
              .then(res => {
                let role = res.role
                role.users = [];
                self.roles.push(role);
              })
          });
      },
      initUserFormData(dialogState, index = null, row = null){
        this.dialogVisible = true;
        if (dialogState === 'new') {
          this.userFormData.rules.password = [
            {required: true, message: 'please enter password', trigger: 'blur'},
            {min: 4, max: 15, message: '4 to 15', trigger: 'change'}
          ];
          this.userFormData.data = {
            username: '',
            password: '',
            tel: '',
            state: false,
            role: ''
          }
        }
        if (dialogState === 'edit') {
          this.userFormData.rules.password = [
            {min: 4, max: 15, message: '4 to 15', trigger: 'change'}
          ];
          this.userFormData.data = {
            username: row.username,
            password: '',
            tel: row.tel,
            state: !!row.state,
            role: row.roles[0]['id'].toString()
          }
        }
      },
      saveUser(formName){
        let self = this;
        this.$refs[formName].validate(valid => {
          if (valid) {
            let postData = {
              username: self.userFormData.data.username,
              role_id: self.userFormData.data.role,
              state: self.userFormData.data.state ? 1 : 0
            }
            if (self.userFormData.data.password) postData.password = self.userFormData.data.password;
            if (self.userFormData.data.tel) postData.tel = self.userFormData.data.tel;
            axios.post('/users', qs.stringify(postData))
              .then(res => {
                self.users.push(res.user);
              })
            self.dialogVisible = false;
          } else {
            console.error('error');
            return false
          }
        })
      },
      removeUser(index, row) {
        axios.delete(`users/${row.id}`)
          .then(res => {
            this.users.forEach((user, index) => {
              if (user.id === row.id) {
                this.users.splice(index, 1);
              }
            })
          })
      }
    },
    mounted(){
      let self = this;
      !async function () {
        let [roles, users] = await Promise.all([axios.get('/roles'), axios.get('/users')]);
        self.roles = roles['roles'];
        self.users = users['users'];
      }()
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .user {
    .role-area {
      .box-card {
        min-height: 90vh;
        .role-header, .role-item, .add-role {
          cursor: pointer;
        }
        .role-header {
          color: #62a8ea;
          &:hover {
            background-color: #f3f7f9;
          }
        }
        .role-item-title {
          margin-bottom: 15px;
          font-size: 18px;
          font-weight: 700;
        }
        .role-item {
          padding: 10px 0;
          &:hover {
            color: #62a8ea;
            background-color: #f3f7f9;
          }
        }
        .add-role {
          padding: 15px 0;
          margin-top: 10px;
          &:hover {
            background-color: #f3f7f9;
          }
        }
      }
    }
    .user-area {
      padding: 15px;
      .box-card {
        min-height: 85vh;
        h2 {
          margin-bottom: 5px;
        }
        .add_btn {
          margin-bottom: 15px;
        }
      }
    }
  }
</style>
