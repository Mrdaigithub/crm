<template>
  <div class="welcome-page">
    <h1><i class="el-icon-ali-logo"></i></h1>
    <p>客户关系管理系统<br>
      <small class="version">alpha V 0.3.6</small>
    </p>
    <el-button class="btn" @click="start" :loading="btnLoading">{{btnLoading ? '应用初始化' : '开始使用'}}</el-button>
  </div>
</template>

<script>
  export default {
    name: 'welcome',
    methods: {
      start () {
        this.$router.push('/login')
      }
    },
    data () {
      return {
        btnLoading: true
      }
    },
    mounted () {
      if (sessionStorage.token) delete sessionStorage.token
      this.btnLoading = false
    }
  }
</script>

<style lang="scss">
  @keyframes turn {
    0% {
      transform: rotateY(0deg);
    }
    0% {
      transform: rotateY(360deg);
    }
  }

  .welcome-page {
    overflow: hidden;
    height: 100vh;
    text-align: center;
    background: radial-gradient(#00ac9e 10%, #009688 43%);
    h1 {
      animation: turn 6s;
      margin-top: 15vh;
      line-height: 40vh;
      color: #fff;
      font-size: 240px;
    }
    p {
      color: #fff;
      font-size: 30px;
      .version {
        font-size: 26px;
      }
    }
    .btn {
      margin-top: 15vh;
      background-color: transparent;
      color: #fff;
      border: 2px solid #fff;
      &:before{
        background-color: transparent;
      }
    }
  }
</style>
