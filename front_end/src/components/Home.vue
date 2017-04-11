<template>
  <div class="home">
    <Row type="flex">
      <i-col span="5" class="layout-menu-left">
        <Menu active-name="2-1" theme="dark" width="auto" :open-names="['2']">
          <div class="layout-logo-left"></div>
          <Submenu v-for="menu of menuData" :key="menu.name" :name="menu.name">
            <template slot="title">{{menu.title}}</template>
            <Menu-item v-for="subMeun of menu.child" :key="subMeun.name" :name="subMeun.name">
              <router-link :to="subMeun.url">{{subMeun.title}}</router-link>
            </Menu-item>
          </Submenu>
        </Menu>
      </i-col>
      <i-col span="19">
        <div class="layout-header"></div>
        <div class="layout-content">
          <div class="layout-content-main"><router-view></router-view></div>
        </div>
        <div class="layout-copy">2011-2016 &copy; TalkingData</div>
      </i-col>
    </Row>
  </div>
</template>

<script>
  import qs from 'qs'
  import axios from 'axios'

  export default {
    name: 'home',
    data: function () {
      return {
        menuData: []
      }
    },
    mounted: function () {
      let getMenu = async () => {
        let res = (await axios.get(`http://localhost/crm/back_end/api/v1/menu/?token=${localStorage.token}`)).data
        this.menuData = res['menu_data']

//        缺少token参数或无效的token，退回登陆界面
        if (res.stateCode === 41001 || res.stateCode === 40014) this.$router.push('login')

//        token超时
        if (res.stateCode === 42001) {
          localStorage.token = (await axios.patch('http://localhost/crm/back_end/api/v1/token/', qs.stringify({token: localStorage.token}))).data.token
          this.menuData = (await axios.get(`http://localhost/crm/back_end/api/v1/menu/?token=${localStorage.token}`)).data
        }
      }
      if (!this.menuData.length) getMenu()
    }
  }
</script>

<style scoped lang="scss">
  .home {
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    border: 1px solid #d7dde4;
    background: #f5f7f9;
    position: relative;
  }

  .layout-breadcrumb {
    padding: 10px 15px 0;
  }

  .layout-content {
    min-height: 200px;
    margin: 15px;
    overflow: hidden;
    background: #fff;
    border-radius: 4px;
  }

  .layout-content-main {
    padding: 50px 10px;
  }

  .layout-copy {
    text-align: center;
    padding: 10px 0 20px;
    color: #9ea7b4;
  }

  .layout-menu-left {
    background: #464c5b;
    height: 100vh;
    overflow-y: scroll;
    &::-webkit-scrollbar {
      width: 0;
    }
  }

  .layout-header {
    height: 60px;
    background: #fff;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .1);
  }

  .layout-logo-left {
    width: 90%;
    height: 30px;
    background: #5b6270;
    border-radius: 3px;
    margin: 15px auto;
  }
</style>
