<template>
  <div id="app">
    <vue-progress-bar></vue-progress-bar>
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'crm',
    mounted(){
      if (!localStorage.token) this.$router.push('login')
      else this.$router.push('home')
    }
  }
</script>
<style lang="scss">
  *{
    margin: 0;
    padding: 0;
  }
  h1, h2, h3, h4, h5, h6 {
    font-weight: 100;
  }
</style>
