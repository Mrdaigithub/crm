<template>
  <div class="home">
    <Row type="flex">
      <i-col span="5" class="layout-menu-left">
        <Menu active-name="2-1" theme="dark" width="auto" :open-names="['2']">
          <div class="layout-logo-left"></div>
          <Submenu v-for="m of menu" :key="m.name" :name="m.name">
            <template slot="title">{{m.title}}</template>
            <Menu-item v-for="subM of m.child" :key="subM.name" :name="subM.name">
              <router-link :to="subM.url">{{subM.title}}</router-link>
            </Menu-item>
          </Submenu>
        </Menu>
      </i-col>
      <i-col span="19">
        <div class="layout-header"></div>
        <div class="layout-content">
          <div class="layout-content-main">
            <router-view></router-view>
          </div>
        </div>
      </i-col>
    </Row>
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
    methods: {},
    mounted(){
      let self = this
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
    overflow-y: scroll;
    min-height: 200px;
    height: 90vh;
    margin: 15px;
    background: #fff;
    border-radius: 4px;
  }

  .layout-content-main {
    padding: 50px 10px;
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
