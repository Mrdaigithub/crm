<template>
  <div id="app">
    <link href="https://fonts.googleapis.com/css?family=Mogra" rel="stylesheet">
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'app',
    mounted(){
      if (sessionStorage.token) this.$router.replace('/home/console')
      else this.$router.replace('/login')
    }
  }
</script>

<style>
  body, h1, h2, h3, h4, h5, h6, div, span, p, strong, canvas {
    margin: 0;
    padding: 0;
  }
  a{
    text-decoration: none;
    color: #48576a;
  }
  #app {
    font-family: 'Mogra', 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    width: 100vw;
    height: 100vh;
    overflow: hidden;
  }
</style>
