<template>
  <el-col :span="4" class="left-bar">
    <el-dropdown trigger="click" class="user-profile">
      <div class="user-menu">
        <div class="user-pic"><img :src="$store.state.oneself.headimgurl" alt="user"></div>
        <span class="el-dropdown-link">
              Hi:&nbsp;&nbsp;<span>{{$store.state.oneself.username}}</span><i
          class="el-icon-caret-bottom el-icon--right"></i>
            </span>
      </div>
      <el-dropdown-menu slot="dropdown" style="width: 230px;">
        <el-dropdown-item>user setting</el-dropdown-item>
        <el-dropdown-item @click.native="logout">logout</el-dropdown-item>
      </el-dropdown-menu>
    </el-dropdown>

    <el-menu theme="default" class="el-menu-vertical">
      <el-menu-item v-for="menu in $store.state.menus" :index="menu.id.toString()" :key="menu.id" v-if="!menu.children.length">
        <router-link :to="menu.url">{{menu.name}}</router-link>
      </el-menu-item>
      <el-submenu v-for="menu in $store.state.menus" :index="menu.id.toString()" :key="menu.id" v-if="menu.children.length">
        <template slot="title">{{menu.name}}</template>
        <el-menu-item v-for="subMenu in menu.children" :index="subMenu.id.toString()" :key="subMenu.id">
          <router-link :to="subMenu.url">{{subMenu.name}}</router-link>
        </el-menu-item>
      </el-submenu>
    </el-menu>
  </el-col>
</template>

<script>
  export default {
    methods: {
      logout () {
        if (sessionStorage.token) delete sessionStorage.token
        this.$router.replace('login')
      }
    },
    mounted () {
      if (!this.$store.state.menu) this.$store.dispatch('getMenu')
    }
  }
</script>

<style scoped lang="scss">
  a {
    text-decoration: none;
    color: #48576a;
  }

  .left-bar {
    height: 90vh;
    background-color: #eef1f6;
    .user-profile {
      position: relative;
      width: 100%;
      height: 15vh;
      .user-menu {
        height: 125px;
        background: url("http://material.23air.com/Public/2017/img/profile-menu.png") no-repeat;
        background-size: 100% 100%;
        .user-pic {
          padding: 8px;
          img {
            width: 25%;
            border: 3px solid rgba(0, 0, 0, .14);
            border-radius: 50%;
          }
        }
        .el-dropdown-link {
          position: absolute;
          bottom: 0;
          left: 0;
          display: block;
          line-height: 33px;
          width: 100%;
          color: #fff;
          background-color: rgba(0, 0, 0, .5);
          text-indent: 10px;
        }
      }
    }
    .el-menu-vertical {
      overflow-y: scroll;
      height: 75vh;
      a {
        display: block;
      }
    }
  }
</style>
