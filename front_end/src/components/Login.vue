<template>
  <el-form :model="loginInfo" :rules="loginRules" ref="loginInfo" label-width="100px" class="login-form">
    <el-form-item label="用户名" prop="username">
      <el-input type="text" v-model="loginInfo.username" auto-complete="on"></el-input>
    </el-form-item>
    <el-form-item label="密码" prop="password">
      <el-input type="password" v-model="loginInfo.password" auto-complete="off"
                @keyup.native.enter="login('loginInfo')"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="login('loginInfo')" :loading="loading" :disabled="disabled" class="login-btn">
        登录
      </el-button>
    </el-form-item>
  </el-form>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default{
    name: 'login',
    data() {
      var validateUsername = (rule, value, callback) => {
        if (value.trim() === '') {
          callback(new Error('请输入用户名'));
        } else if (!/^[0-9a-zA-Z]+$/.test(value)) {
          callback(new Error('不能包含特殊字符'));
        } else {
          callback();
        }
      };
      var validatePass = (rule, value, callback) => {
        if (value.trim() === '') {
          callback(new Error('请输入密码'));
        } else {
          callback();
        }
      };
      return {
        loading: false,
        loginInfo: {
          username: '',
          password: ''
        },
        loginRules: {
          username: [
            {validator: validateUsername, trigger: 'blur'}
          ],
          password: [
            {validator: validatePass, trigger: 'blur'}
          ]
        }
      };
    },
    computed: {
      disabled(){
        return !this.loginInfo.username || !this.loginInfo.password
      }
    },
    methods: {
      login(formName) {
        if (this.disabled) return false
        let self = this;
        self.loading = true
        this.$refs[formName].validate((valid) => {
          if (valid) {
            !async function () {
              let res = (await axios.post('http://crm.mrdaisite.com/back_end/api/v1/token/', qs.stringify({
                username: self.loginInfo.username.trim(),
                password: self.loginInfo.password.trim()
              }))).data
              if (res.token) {
                self.loading = false
                localStorage.token = res.token
                self.$router.replace('home')
              }

              if (res['state_code'] === 40036) self.$message.error('用戶名或密碼缺失');
              if (res['state_code'] === 40035) self.$message.error('用戶名或密碼不合法');
              if (res['state_code'] === 46004) self.$message.error('用户名错误或无此用户');
              if (res['state_code'] === 46005) self.$message.error('密码错误');
              self.loading = false
            }()
          } else {
            return false;
          }
        });
      }
    }
  }
</script>
<style scoped lang="scss">
  .login-form {
    text-align: center;
    width: 30vw;
    margin: 30vh auto 0 auto;
    .login-btn {
      width: 100%;
    }
  }
</style>
