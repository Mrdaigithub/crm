<template>
  <div class="user">
    <h2>User list</h2>
    <el-card class="box-card">
      <el-row>
        <el-col :span="6" class="role-area">
          <el-card class="box-card">
            <div slot="header" class="clearfix role-header">
            <span style="line-height: 36px" @click="currentRoleId = 'all'">
              All users<el-badge class="mark" :value="users.length"/>
            </span>
            </div>
            <div class="role-item-title">Role</div>
            <div v-for="role in roles" class="role-item" :key="role.id" @click="currentRoleId = role.id">
              {{role.name}}
              <el-badge class="mark" :value="getRoleUserLength(role.id)"/>
              <div class="role-btns">
                <el-button type="danger" size="mini" icon="delete" class="role-edit-btn"
                           @click="removeRole(role.id)"></el-button>
                <el-button type="default" size="mini" icon="edit" class="role-remove-btn"
                           @click="editRole(role.id)"></el-button>
                <el-button type="default" size="mini" icon="setting" class="setting-permission-btn"
                           @click="editPermission(role.id)"></el-button>
              </div>
            </div>
            <hr>
            <div class="add-role" @click="addRole">Add new role</div>
          </el-card>
        </el-col>
        <el-col :span="18" class="user-area">
          <el-card class="box-card">
            <float-button @click.native="initUserFormData('new')"/>
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
      <el-dialog title="Edit user info" :visible.sync="userDialogVisible" size="small">
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
      <el-dialog title="Permission" :visible.sync="permissionDialogVisible" top="5%">
        <el-tree
          class="permissions-tree scrollbar"
          v-loading.body="permissionLoading"
          :data="permissionsData"
          show-checkbox
          highlight-current
          default-expand-all
          :default-checked-keys="defaultCheckedPermissionsKeys"
          node-key="id"
          :indent="36"
          :props="permissionsProps"
          @check-change="selectPermission">
        </el-tree>
        <div slot="footer" class="dialog-footer">
          <el-button type="primary" @click="savePermission" style="width: 100%">submit</el-button>
        </div>
      </el-dialog>
    </el-card>
  </div>
</template>

<script>
  import FloatButton from '~components/FloatButton.vue'
  import axios from '../../config/axios'
  import qs from 'qs'

  export default {
    name: 'user',
    components: {
      FloatButton
    },
    data () {
      return {
        roles: [],
        users: [],
        currentRoleId: 'all',
        currentUser: {},
        userDialogVisible: false,
        permissionDialogVisible: false,
        dialogState: 'new',
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
        },
        permissionsData: [],
        permissionsProps: {
          children: 'children',
          label: 'description'
        },
        permissionLoading: false
      }
    },
    computed: {
      showUsersData () {
        let showUsersData = []
        if (this.currentRoleId === 'all') return this.users
        else {
          for (let user of this.users) {
            if (this.currentRoleId === user['roles'][0]['id']) {
              showUsersData.push(user)
            }
          }
          return showUsersData
        }
      },
      defaultCheckedPermissionsKeys () {
        if (!this.permissionsData.length) return []
        let checkedKeys = []
        this.permissionsData.forEach(pItem => {
          if (pItem.state && !pItem.children.length) checkedKeys = checkedKeys.concat(pItem.id)
          pItem.children.forEach(item => {
            if (item.state) checkedKeys = checkedKeys.concat(item.id)
          })
        })
        return checkedKeys
      }
    },
    methods: {
      getRoleUserLength (roleId) {
        let self = this
        let len = 0
        for (let user of self.users) {
          if (user['roles'][0]['id'] === roleId) len++
        }
        return len
      },
      addRole () {
        let self = this
        this.$prompt('Please enter a role name', 'Tips')
          .then(({value}) => {
            axios.get(`/roles/${value}/create`)
              .then(res => {
                let role = res.role
                role.users = []
                self.roles.push(role)
              })
          })
      },
      editRole (roleId) {
        let self = this
        let rIndex = null
        let currentRole = null
        self.roles.forEach((role, index) => {
          if (role.id === roleId) {
            currentRole = role
            rIndex = index
          }
        })
        this.$prompt('enter a new role name', 'Tips', {
          confirmButtonText: 'submit',
          showCancelButton: false,
          inputPattern: /\w{4,20}/,
          inputValidator: function (val) {
            if (val === currentRole.name) return false
          },
          inputErrorMessage: 'name format is error'
        }).then(({value}) => {
          axios.patch(`/roles/${roleId}`, qs.stringify({name: value}))
            .then(res => {
              self.roles.splice(rIndex, 1, res.role)
            })
        })
      },
      removeRole (roleId) {
        let self = this
        let rIndex = null
        self.roles.forEach((role, index) => {
          if (role.id === roleId) rIndex = index
        })
        axios.delete(`/roles/${roleId}`)
          .then(res => {
            self.roles.splice(rIndex, 1)
          })
      },
      initUserFormData (dialogState, index = null, row = null) {
        this.userDialogVisible = true
        this.dialogState = dialogState
        this.currentUser = row
        if (dialogState === 'new') {
          this.userFormData.rules.password = [
            {required: true, message: 'please enter password', trigger: 'blur'},
            {min: 4, max: 15, message: '4 to 15', trigger: 'change'}
          ]
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
          ]
          this.userFormData.data = {
            username: row.username,
            password: '',
            tel: row.tel,
            state: !!row.state,
            role: row.roles[0]['id'].toString()
          }
        }
      },
      saveUser (formName) {
        let self = this
        let postData = {}
        this.$refs[formName].validate(valid => {
          if (valid) {
            if (self.dialogState === 'new') {
              postData = {
                username: self.userFormData.data.username,
                role_id: self.userFormData.data.role,
                state: self.userFormData.data.state ? 1 : 0
              }
              if (self.userFormData.data.password) postData.password = self.userFormData.data.password
              if (self.userFormData.data.tel) postData.tel = self.userFormData.data.tel
              axios.post('/users', qs.stringify(postData))
                .then(res => {
                  self.users.push(res.user)
                })
            } else if (self.dialogState === 'edit') {
              postData = {
                role_id: self.userFormData.data.role,
                state: self.userFormData.data.state ? 1 : 0
              }
              if (self.userFormData.data.username !== self.currentUser['username']) {
                postData['username'] = self.userFormData.data.username
              }
              if (self.userFormData.data.password) postData.password = self.userFormData.data.password
              if (self.userFormData.data.tel) postData.tel = self.userFormData.data.tel
              axios.patch(`/users/${self.currentUser.id}`, qs.stringify(postData))
                .then(res => {
                  let startIndex
                  self.users.forEach((user, index) => {
                    if (user.id === self.currentUser.id) startIndex = index
                  })
                  self.users.splice(startIndex, 1, res.user)
                })
            }
            self.userDialogVisible = false
          } else {
            console.error('error')
            return false
          }
        })
      },
      removeUser (index, row) {
        axios.delete(`users/${row.id}`)
          .then(res => {
            this.users.forEach((user, index) => {
              if (user.id === row.id) {
                this.users.splice(index, 1)
              }
            })
          })
      },
      editPermission (roleId) {
        let self = this
        this.permissionDialogVisible = true
        this.permissionLoading = true
        axios.get(`permissions/${roleId}`)
          .then(permissionsData => {
            self.permissionsData = permissionsData
            this.permissionLoading = false
          })
      },
      selectPermission (data, checked) {
        for (let pItem of this.permissionsData) {
          if (pItem.id === data.id) {
            pItem.state = checked
            return
          }
          for (let item of pItem.children) {
            if (item.id === data.id) {
              item.state = checked
              return
            }
          }
        }
      },
      selectPermissionAll (selection) {
        if (selection.length === 0) {
          this.permissions.forEach(permission => {
            permission.selected = false
          })
        } else {
          this.permissions.forEach(permission => {
            permission.selected = true
          })
        }
      },
      savePermission () {
        let self = this
        axios.put(`permissions/${self.currentRoleId}`, qs.stringify({permissions: self.permissionsData}))
          .then(res => {
            this.permissionDialogVisible = false
          })
      }
    },
    mounted () {
      let self = this
      !(async function () {
        if (!self.$store.state.users) {
          let [{roles}, {users}] = await Promise.all([axios.get('/roles'), axios.get('/users')])
          self.roles = roles
          self.$store.state.users = users
          self.users = self.$store.state.users
        } else {
          let {roles} = await axios.get('/roles')
          self.roles = roles
          self.users = self.$store.state.users
        }
        self.$store.state.loading = false
      }())
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
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
          position: relative;
          &:hover {
            color: #62a8ea;
            background-color: #f3f7f9;
            .role-btns {
              display: block;
            }
          }
          .role-btns {
            display: none;
            padding: 10px 0;
            position: absolute;
            right: 0;
            top: 0;
            .role-remove-btn, .role-edit-btn, .setting-permission-btn {
              margin-left: 1px;
            }
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
      .box-card {
        min-height: 90vh;
        h2 {
          margin-bottom: 5px;
        }
        .add_btn {
          margin-bottom: 15px;
        }
      }
    }
    .permissions-tree {
      height: 65vh;
    }
  }
</style>
