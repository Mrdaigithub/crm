<template>
  <el-row class="top-bar" type="flex" justify="space-between">
    <el-col :span="4" class="logo">
      <h1 @click="toDashbord"><i class="el-icon-ali-logo"></i></h1>
    </el-col>
    <el-col :span="3" class="user-area">
      <el-dropdown trigger="click" class="user-profile">
        <div class="user-menu">
          <img :src="$store.state.oneself.headimgurl" alt="headimg" class="headimg">
          <span class="el-dropdown-link">{{$store.state.oneself.username}}</span>
        </div>
        <el-dropdown-menu slot="dropdown" class="user-dropdown">
          <el-dropdown-item class="user-dropdown-item"><i class="el-icon-setting"></i> setting</el-dropdown-item>
          <el-dropdown-item @click.native="logout"><i class="el-icon-ali-logout"></i> logout</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-col>
  </el-row>
</template>

<script>
  import axios from '../config/axios'

  export default {
    name: 'topBar',
    methods: {
      toDashbord () {
        this.$router.push('/home/dashboard')
      },
      logout () {
        let self = this
        axios.get('/logout')
          .then(res => {
            if (sessionStorage.token) delete sessionStorage.token
            self.$router.replace('login')
          })
      }
    }
  }
</script>

<style lang="scss">
  .top-bar {
    position: relative;
    z-index: 999;
    height: 10vh;
    line-height: 10vh;
    background-color: #009688;
    h1 {
      display: inline-block;
      font-size: 66px;
      text-indent: 10px;
      color: #fff;
      cursor: pointer;
    }
    .user-area{
      .user-menu{
        height: 10vh;
        line-height: 10vh;
        cursor: pointer;
        .headimg{
          width: 7vh;
          border-radius: 50%;
          overflow: hidden;
          vertical-align: middle;
          margin-right:10px;
        }
        span{
          font-size:16px;
          font-weight:600;
          color: #fff;
          vertical-align: middle;
        }
      }
      .user-dropdown{
        i{
          display: inline-block;
          margin-right:5px;
        }
      }
    }
  }
</style>
