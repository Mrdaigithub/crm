<template>
  <el-row class="top-bar" type="flex" justify="space-between">
    <el-col :span="4" class="logo">
      <h1>logo</h1>
    </el-col>
  </el-row>
</template>

<style scoped lang="scss">
  .top-bar {
    position: relative;
    z-index: 999;
    height: 10vh;
    line-height: 10vh;
    background-color: #58B7FF;
    box-shadow: 0 1px 3px #333;
  }
</style>
