<template>
  <div class="user">
    <el-row>
      <el-col :span="6" class="role-area">
        <el-card class="box-card">
          <div slot="header" class="clearfix role-header">
            <span style="line-height: 36px;">All users <el-badge class="mark" :value="12" /></span>
          </div>
          <div class="role-item-title">Role</div>
          <div class="role-item">Root group<el-badge class="mark" :value="12" /></div>
          <div class="role-item">Admin group<el-badge class="mark" :value="12" /></div>
          <div class="role-item">user group<el-badge class="mark" :value="12" /></div>
          <hr>
          <div class="add-role">Add new role</div>
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
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .user{
    .role-area{
      .box-card{
        height:90vh;
        .role-header, .role-item, .add-role{
          cursor: pointer;
        }
        .role-header{
          color: #62a8ea;
          &:hover{
            background-color: #f3f7f9;
          }
        }
        .role-item-title{
          margin-bottom:15px;
          font-size:18px;
          font-weight:700;
        }
        .role-item{
          padding:10px 0;
          &:hover{
            color: #62a8ea;
            background-color: #f3f7f9;
          }
        }
        .add-role{
          padding:15px 0;
          margin-top:10px;
          &:hover{
            background-color: #f3f7f9;
          }
        }
      }
    }
  }
</style>
