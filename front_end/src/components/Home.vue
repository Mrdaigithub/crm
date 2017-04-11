<template>
  <div class="home">
    <Row type="flex">
      <i-col span="4" class="layout-menu-left">
        <Menu active-name="1-1" theme="dark" width="auto" :open-names="['1']">
          <div class="layout-logo-left"></div>
          <Submenu name="1">
            <template slot="title">
              <Icon type="ios-navigate"></Icon>
              导航一

            </template>
            <Menu-item name="1-1">选项 1</Menu-item>
            <Menu-item name="1-2">选项 2</Menu-item>
            <Menu-item name="1-3">选项 3</Menu-item>
          </Submenu>
          <Submenu name="2">
            <template slot="title">
              <Icon type="ios-keypad"></Icon>
              导航二

            </template>
            <Menu-item name="2-1">选项 1</Menu-item>
            <Menu-item name="2-2">选项 2</Menu-item>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              导航三

            </template>
            <Menu-item name="3-1">选项 1</Menu-item>
            <Menu-item name="3-2">选项 2</Menu-item>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              导航三

            </template>
            <Menu-item name="3-1">选项 1</Menu-item>
            <Menu-item name="3-2">选项 2</Menu-item>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              导航三

            </template>
            <Menu-item name="3-1">选项 1</Menu-item>
            <Menu-item name="3-2">选项 2</Menu-item>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              导航三

            </template>
            <Menu-item name="3-1">选项 1</Menu-item>
            <Menu-item name="3-2">选项 2</Menu-item>
          </Submenu>
          <Submenu name="3">
            <template slot="title">
              <Icon type="ios-analytics"></Icon>
              导航三

            </template>
            <Menu-item name="3-1">选项 1</Menu-item>
            <Menu-item name="3-2">选项 2</Menu-item>
          </Submenu>
        </Menu>
      </i-col>
      <i-col span="20">
        <div class="layout-header"></div>
        <div class="layout-content">
          <div class="layout-content-main">内容区域</div>
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
      let self = this
      let getMenu = async () => {
//        let res = await axios.get(`http://localhost/crm/back_end/api/v1/menu/?token=${localStorage.token}`)
        let res = await axios.patch(`http://localhost/crm/back_end/api/v1/token/`,`token=${localStorage.token}`)

        //        token错误，退回登陆界面
//        if (res.data.stateCode === 40014) self.$router.push('login')
//
//        //        token过期，自动换个新的
//        if (res.data.stateCode === 42001) {
//          localStorage.token = (await axios.post(
//            'http://localhost/crm/back_end/api/v1/token/',
//            qs.stringify({token: localStorage.token})
//          )).data.token
//        }
//
//        this.menuData = (await axios.get(`http://localhost/crm/back_end/api/v1/menu/?token=${localStorage.token}`)).data
      }
      getMenu()
//      axios.get(`http://localhost/crm/back_end/api/v1/menu/?token=${localStorage.token}`)
//        .then(function (response) {
////            token过期，自动换个新的
//          if (response.data.stateCode === 42001) {
//            axios.post('http://localhost/crm/back_end/api/v1/token/', qs.stringify({
//              token: localStorage.token,
//            }))
//              .then(response => {
//                localStorage.token = response.data.token
//              })
//              .catch(err => {
//                console.log(err)
//              })
//          }
//
//          //              token错误，退回登陆界面
//          if (response.data.stateCode === 40014) {
//            self.$router.push('login')
//          }
//        })
//        .catch(function (error) {
//          console.log(error);
//        })
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
    padding: 10px;
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
