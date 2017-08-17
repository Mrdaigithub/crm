<template>
  <el-row class="top-bar" type="flex" justify="space-between">
    <el-col :span="4" class="logo">
      <h1><i class="el-icon-ali-logo"></i></h1>
    </el-col>
    <el-col :span="2" class="user-area">
      <el-dropdown trigger="click" class="user-profile">
        <div class="user-menu text-center">
          <span class="headimg" :style="headColor">{{firstName}}</span>
          <i class="el-icon-ali-more"></i>
        </div>
        <el-dropdown-menu slot="dropdown" class="user-dropdown">
          <el-dropdown-item class="user-dropdown-item"><i class="el-icon-setting"></i> 用户设置</el-dropdown-item>
          <el-dropdown-item @click.native="logout"><i class="el-icon-ali-logout"></i> 退出登录</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </el-col>
  </el-row>
</template>

<script>
  import axios from '../config/axios'

  export default {
    name: 'topBar',
    computed: {
      firstName () {
        if (!this.$store.state.oneself.username) return ''
        return this.$store.state.oneself.username[0].toUpperCase()
      },
      headColor () {
        let colors = ['#dd4e41', '#4c8bf5', '#ffce42', '#717171', '#b2b2b2', '#7e57c2', '#9999FF', '#660033', '#3399CC', '#333333']
        if (!this.$store.state.oneself.username) return {backgroundColor: colors[0]}
        let sub = (this.$store.state.oneself.id / 1024 * 65535 / 22 * 8388).toString()[1]
        return {backgroundColor: colors[sub]}
      }
    },
    methods: {
      logout () {
        let self = this
        axios.get('/logout')
          .then(res => {
            if (sessionStorage.token) delete sessionStorage.token
            self.$router.replace('login')
          })
      }
    },
    mounted () {
      let self = this
      !(async function () {
        let {user} = await axios.get('/users/0')
        self.$store.commit('getOneself', user)
      })()
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
    }
    .user-area {
      .user-menu {
        height: 10vh;
        line-height: 10vh;
        cursor: pointer;
        .headimg {
          display: inline-block;
          text-align: center;
          width: 3.5vw;
          line-height: 3.5vw;
          font-size: 26px;
          border-radius: 50%;
          overflow: hidden;
          color: #fff;
          font-weight: bold;
          vertical-align: middle;
          margin-right: 10px;
        }
        .el-icon-ali-more {
          font-size: 30px;
          color: #fff;
          vertical-align: middle;
        }
      }
      .user-dropdown {
        i {
          display: inline-block;
          margin-right: 5px;
        }
      }
    }
  }
</style>
