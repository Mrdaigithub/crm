<template>
  <div class="home">
    <top-bar/>
    <el-row>
      <el-col :span="4">
        <menu-bar/>
      </el-col>
      <el-col :span="20" class="main scrollbar" v-loading.body="$store.state.loading">
        <router-view></router-view>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import TopBar from '~components/TopBar.vue'
  import MenuBar from '~components/MenuBar.vue'

  export default {
    name: 'home',
    components: {
      TopBar,
      MenuBar
    }
  }
</script>

<style lang="scss">
  body, h1, h2, h3, h4, h5, h6, div, span, p, strong, canvas {
    margin: 0;
    padding: 0;
  }

  .pull-left {
    float: left;
  }

  .pull-right {
    float: right;
  }

  .clearfix {
    overflow: hidden;
    clear: both;
  }

  .home {
    font-family: 'Mogra', 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
    .main {
      height: 90vh;
      box-sizing: border-box;
      background-color: #edf1f5;
      h2 {
        font-size: 18px;
        text-indent: 20px;
        line-height: 63px;
        color: rgba(0, 0, 0, .5);
        background-color: #fff;
      }
      .box-card {
        margin: 20px;
        min-height: 85vh;
        .form-group{
          margin:30px 0 17px 0;
        }
        .pagination{
          margin:35px 0 25px 0;
        }
      }
    }
    .scrollbar {
      overflow: scroll;
      &::-webkit-scrollbar {
        width: 10px;
        height: 10px;
      }
      &::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, .3);
      }
      &::-webkit-scrollbar-corner {
        background-color: transparent;
      }
    }
  }
</style>
