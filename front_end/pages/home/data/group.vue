<template>
  <div class="group-data" v-loading.body="$store.state.loading">
    <el-card class="box-card">
      group data
    </el-card>
  </div>
</template>

<script>
  export default {
    name: 'groupData'
  }
</script>

<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 25px;
    }
    .rank-card {
      margin: 0 8px;
    }
  }
</style>
