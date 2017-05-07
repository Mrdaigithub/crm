<template>
  <div class="home">
    <el-row class="top-bar">
      <el-col :span="6" class="logo">
        <h1>LOGO</h1>
      </el-col>
      <el-col :span="6" :offset="12" class="user">
        <p>user area</p>
      </el-col>
    </el-row>
    <el-row class="main">
      <el-col :span="4" class="menu-bar">
        <el-menu default-active="1" theme="light">
          <el-menu-item v-for="m in menu" :index="m.name" :key="m.name" v-if="!m.child.length">
            <router-link :to="m.url">{{m.title}}</router-link>
          </el-menu-item>
          <el-submenu v-for="m in menu" :index="m.name" :key="m.name" v-if="m.child.length">
            <template slot="title">{{m.title}}</template>
            <el-menu-item v-for="subM in m.child" :index="subM.name" :key="subM.name" class="sub-menu">
              <router-link :to="subM.url">{{subM.title}}</router-link>
            </el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
      <el-col :span="20" class="container">
        <div class="content">
          <router-view></router-view>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'home',
    computed: {
      menu(){
        return this.$store.state.menu
      }
    },
    mounted(){
      let self = this;
      if (!this.menu || !this.menu.length) {
        !async function () {
          let res = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/menu/?token=${localStorage.token}`)).data

//          缺少token参数或无效的token，退回登陆界面
          if (res['state_code'] === 41001 || res['state_code'] === 40014) {
            localStorage.token = ''
            self.$router.push('login')
          }

//          token超时 更換token 重新獲取 menu data
          if (res['state_code'] === 42001) {
            localStorage.token = (await axios.patch('http://crm.mrdaisite.com/back_end/api/v1/token/', qs.stringify({token: localStorage.token}))).data.token
            res = (await axios.get(`http://crm.mrdaisite.com/back_end/api/v1/menu/?token=${localStorage.token}`)).data
          }
          self.$store.dispatch('saveMenu', res['menu_data'])
        }()
      }
    }
  }
</script>

<style lang="scss">
  .home {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    background: #f5f7f9;
    position: relative;
    .top-bar {
      background-color: #324057;
      line-height: 10vh;
      .logo {
        h1 {
          color: #fff;
          text-indent: 3vw;
        }
      }
      .user {
        p {
          color: #fff;
          font-size: 30px;
        }
      }
    }
    .main {
      background-color: #e5e9f2;
      .menu-bar {
        height: 90vh;
        background-color: #eef1f6;
        overflow-y: scroll;
        a {
          display: block;
          width: 100%;
          color: #48576a;
          text-decoration: none;
        }
      }
      .container {
        box-sizing: border-box;
        padding: 2vh;
        .content {
          position: relative;
          height: 86vh;
          background-color: #fff;
          overflow-y: scroll;
          .content-header{
            background-color: #fff;
            color: inherit;
            margin-bottom: 0;
            padding: 14px 15px 7px;
            min-height: 48px;
            h2{
              font-size:30px;
              color: #676a6c;
            }
          }
        }
      }
    }
  }
</style>
