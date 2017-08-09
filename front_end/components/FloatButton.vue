<template>
  <el-button class="float-button"><i class="material-icons">+</i></el-button>
</template>
<style lang="scss">
  .float-button{
    border-radius: 50%;
    position: fixed;
    right: 60px;
    bottom: 80px;
    z-index: 999;
    border:none;
    background-color: #ff4081;
    transition: .2s;
    .material-icons{
      font-weight: normal;
      font-style: normal;
      font-size: 24px;
      line-height: 1;
      color: #fff;
      letter-spacing: normal;
      text-transform: none;
      display: inline-block;
      white-space: nowrap;
      word-wrap: normal;
      direction: ltr;
      -webkit-font-feature-settings: 'liga';
      -webkit-font-smoothing: antialiased;
    }
    &:hover{
      box-shadow: 0 10px 30px rgba(0,0,0,.188235), 0 6px 10px rgba(0,0,0,.227451);
    }
  }
</style>
