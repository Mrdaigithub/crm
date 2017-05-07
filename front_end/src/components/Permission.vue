<template>
  <div>
    <div class="content-header"><h2>为<span class="red">{{roleName}}</span>分配权限,权限对应操作即为权限说明</h2></div>
    <el-tree
      :data="permissionData"
      show-checkbox
      node-key="id"
      :default-expand-all="true"
      :default-checked-keys="defaultCheckedIds"
      :props="defaultProps"
      @check-change="handleCheckChange">
    </el-tree>
    <el-button type="success" size="large" icon="check" class="submit-btn" @click="handleSubmit"> 提交修改</el-button>
  </div>
</template>

<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'permission',
    data () {
      return {
        roleName: '',
        permissionData: [],
        defaultProps: {
          label: 'des',
          children: 'children'
        }
      }
    },
    computed: {
      defaultCheckedIds(){
        if (this.permissionData.length === 0) return []
        return this.permissionData.map(e => {
          if (e.checked) return e.id
        })
      },
      rolePermission(){
        return this.permissionData.map(e => e.checked ? '1' : '0').join('')
      }
    },
    methods: {
      handleCheckChange(data, checked){
        this.permissionData.forEach(e => {
          if (e.id === data.id) e.checked = checked;
        })
      },
      handleSubmit(){
        let self = this;
        self.$Progress.start();
        !async function () {
          await axios.put('http://crm.mrdaisite.com/back_end/api/v1/permission/', qs.stringify({
            token: localStorage.token,
            role_name: self.roleName,
            role_permission: self.rolePermission
          }))
          self.$alert('操作成功', {
            confirmButtonText: '我知道了',
            callback: action => {
              self.$Progress.finish();
              self.$router.replace({name: 'role'});
            }
          });
        }()
      },
    },
    mounted(){
      let self = this;
      if (!this.$route.params.RoleName) {
        this.$router.replace({name: 'role'});
      }
      this.roleName = this.$route.params.RoleName;
      !async function () {
        self.permissionData = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/permission/?token=${localStorage.token}&role_name=${self.roleName}`)).data
      }()
    }
  }
</script>

<style scope lang="scss">
  .red {
    color: #ff0000;
  }

  .submit-btn {
    margin-top: 20px !important;
    width: 100%;
  }
</style>
