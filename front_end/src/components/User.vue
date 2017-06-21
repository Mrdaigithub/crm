<template>
  <div class="user">
    <el-row>
      <el-col :span="6" class="role-area">
        <el-card class="box-card">
          <div slot="header" class="clearfix role-header">
            <span style="line-height: 36px;">All users <el-badge class="mark" :value="users.length"/></span>
          </div>
          <div class="role-item-title">Role</div>
          <div v-for="role in roles" class="role-item" :key="role.id">{{role.name}}
            <el-badge class="mark" :value="role.users.length"/>
          </div>
          <hr>
          <div class="add-role" @click="addRole">Add new role</div>
        </el-card>
      </el-col>
      <el-col :span="18">right</el-col>
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
        users: []
      }
    },
    methods: {
      addRole(){
        let self = this;
        this.$prompt('Please enter a role name', 'Tip')
          .then(({roleName}) => {
            console.log(roleName);

//            axios.get(`/roles/${roleName}/create`)
//              .then(newRole=>{
//                console.log(newRole);
//              })
//            newRole.users = [];
//            self.roles.push(newRole);
          });
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
      }()
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .user {
    .role-area {
      .box-card {
        height: 90vh;
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
  }
</style>
