<template>
  <div id="app">
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
