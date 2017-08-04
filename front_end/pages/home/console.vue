<template>
  <div class="console">
    <h2>{{msg}}</h2>
    <el-card class="box-card">
      {{msg}}
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'console',
    data () {
      return {
        msg: 'Console'
      }
    }
  }
</script>

<style lang="scss">
</style>
