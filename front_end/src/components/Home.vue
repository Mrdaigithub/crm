<template>
  <div class="home">
    <el-row class="top-bar" type="flex" justify="space-between">
      <el-col :span="4" class="logo">
        <h1>logo</h1>
      </el-col>
    </el-row>
    <el-row>
      <el-col :span="4" class="left-bar">
        <el-dropdown trigger="click" class="user-profile">
          <div class="user-menu">
            <div class="user-pic"><img src="http://q1.qlogo.cn/g?b=qq&nk=467732207&s=100&t=1494561756" alt="user"></div>
            <span class="el-dropdown-link">
            Hello: <span>root</span><i class="el-icon-caret-bottom el-icon--right"></i>
          </span>
          </div>
          <el-dropdown-menu slot="dropdown" style="width: 230px;">
            <el-dropdown-item>账号设置</el-dropdown-item>
            <el-dropdown-item>退出</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
        <el-menu default-active="2" class="el-menu-vertical" theme="default">
          <el-submenu index="1">
            <template slot="title">导航一</template>
            <el-menu-item-group title="分组一">
              <el-menu-item index="1-1">选项1</el-menu-item>
              <el-menu-item index="1-2">选项2</el-menu-item>
              <el-menu-item index="1-2">选项2</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="分组2">
              <el-menu-item index="1-3">选项3</el-menu-item>
            </el-menu-item-group>
            <el-submenu index="1-4">
              <template slot="title">选项4</template>
              <el-menu-item index="1-4-1">选项1</el-menu-item>
            </el-submenu>
          </el-submenu>
          <el-menu-item index="2">导航二</el-menu-item>
          <el-menu-item index="3">导航三</el-menu-item>
        </el-menu>
      </el-col>
      <el-col :span="20" class="main">main</el-col>
    </el-row>
  </div>
</template>

<script>
  import axios from '../config/axiosConfig'

  export default {
    name: 'home',
    data () {
      return {
        menu: []
      }
    },
    mounted(){
      let self = this;
//      if (!this.menu || !this.menu.length) {
//        !async function () {
//          let menu = await axios.get(`menu`)
//        }()
//      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .home{
    .top-bar{
      position: relative;
      z-index: 999;
      height:10vh;
      line-height:10vh;
      background-color: #58B7FF;
      box-shadow: 0 1px 5px #000;
    }
    .left-bar{
      height:90vh;
      background-color: #eef1f6;
      .user-profile{
        position: relative;
        width: 100%;
        height:15vh;
        .user-menu{
          height:125px;
          background: url("http://material.23air.com/Public/2017/img/profile-menu.png")no-repeat;
          background-size:100% 100%;
          .user-pic{
            padding:8px;
            img{
              width: 25%;
              border: 3px solid rgba(0,0,0,.14);
              border-radius: 50%;
            }
          }
          .el-dropdown-link{
            position: absolute;
            bottom:0;
            left:0;
            display: block;
            line-height:33px;
            width: 100%;
            color: #fff;
            background-color: rgba(0,0,0,.5);
            text-indent:10px;
          }
        }
      }
      .el-menu-vertical{
        overflow-y: scroll;
        height:75vh;
      }
    }
    .main{
      height:90vh;
      overflow-y: scroll;
    }
  }
</style>
