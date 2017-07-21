<template>
  <div class="home">
    <top-bar/>
    <el-row>
      <menu-bar/>
      <el-col :span="20" class="main">
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
    data () {
      return {
        oneself: {}
      }
    },
    components: {
      TopBar,
      MenuBar
    },
    mounted () {
      if (!this.$store.oneself) this.$store.dispatch('getOneself')
    }
  }
</script>

<style scoped lang="scss">
  body, h1, h2, h3, h4, h5, h6, div, span, p, strong, canvas {
    margin: 0;
    padding: 0;
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
      overflow-y: scroll;
      background-color: #f7f7f7;
    }
  }
</style>
