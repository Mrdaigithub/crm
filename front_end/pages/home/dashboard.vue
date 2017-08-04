<template>
  <div class="dashboard">
    <h2>{{msg}}</h2>
    <el-card class="box-card">
      {{msg}}
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'dashboard',
    data () {
      return {
        msg: 'Dashboard'
      }
    }
  }
</script>

<style lang="scss">
</style>
