<template>
  <div class="user">
    <el-row>
      <el-col :span="6" class="role-area">
        <el-card class="box-card">
          <div slot="header" class="clearfix role-header">
            <span style="line-height: 36px;" @click="showAllUsers">All users
              <el-badge class="mark" :value="users.length"/></span>
          </div>
          <div class="role-item-title">Role</div>
          <div v-for="role in roles" class="role-item" :key="role.id">{{role.name}}
            <el-badge class="mark" :value="role.users.length"/>
          </div>
          <hr>
          <div class="add-role" @click="addRole">Add new role</div>
        </el-card>
      </el-col>
      <el-col :span="18" class="user-area">
        <el-card class="box-card">
          <h2>User List</h2>
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
                  @click="handleEdit(scope.$index, scope.row)" icon="edit"></el-button>
                <el-button
                  size="small"
                  type="danger"
                  @click="handleDelete(scope.$index, scope.row)" icon="delete"></el-button>
              </template>
            </el-table-column>
          </el-table>
        </el-card>
      </el-col>
    </el-row>
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
        showUsersData: [],
        currentRole: ''
      }
    },
    methods: {
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
      showAllUsers(){
        this.showUsersData = this.users;
      },
      handleEdit(index, row) {
        console.log(index, row);
      },
      handleDelete(index, row) {
        console.log(index, row);
      }
    },
    mounted(){
      let self = this;
      !async function () {
        let roles = (await axios.get('/roles'))['roles'];
        for (let role of roles) {
          let role_users = (await axios.get(`/users/role/${role.id}`))['users']
          role.users = role_users ? role_users : [];
        }
        self.roles = roles;
        self.users = (await axios.get('/users'))['users'];
        self.showUsersData = self.users;
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
        height: 85vh;
        h2{
          margin-bottom:30px;
        }
      }
    }
  }
</style>
