<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>

<script>
  export default {
    name: 'crm',
    data: function () {
      return {
        token: localStorage.token
      }
    },
    mounted: function () {
      if (!this.token) this.$router.push('login')
      else this.$router.push('home')
    }
  }
</script>
