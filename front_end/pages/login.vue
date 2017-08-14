<template>
  <div class="login">
    <el-row type="flex" justify="center">
      <el-col :span="8" class="login-wrap">
        <h2><i class="el-icon-ali-logo"></i></h2>
        <h3>登录</h3>
        <el-form :model="loginFrom" :rules="loginRules" ref="loginFrom">
          <el-form-item prop="username">
            <el-input type="text" v-model="loginFrom.username" auto-complete="off" v-focus="true" icon="ali-account"
                      placeholder="用户名"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input type="password" v-model="loginFrom.password" auto-complete="off" icon="ali-lock"
                      @keyup.native.enter="login('loginFrom')" placeholder="密码"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button class="login-btn" type="primary" @click="login('loginFrom')" :disabled="disabled"
                       :loading="btnLoading">login
            </el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import axios from '../config/axios'
  import qs from 'qs'

  export default {
    name: 'login',
    data () {
      return {
        loginFrom: {
          username: '',
          password: ''
        },
        loginRules: {
          username: [
            {required: true, message: '用户名不能为空', trigger: 'blur'},
            {min: 4, message: '用户名过短', trigger: 'blur'},
            {max: 15, message: '用户名过长', trigger: 'blur'}
          ],
          password: [
            {required: true, message: '密码不能为空', trigger: 'blur'},
            {min: 4, message: '密码过短', trigger: 'blur'},
            {max: 15, message: '密码过长', trigger: 'blur'}
          ]
        },
        btnLoading: false
      }
    },
    computed: {
      disabled () {
        return !this.loginFrom.username || !this.loginFrom.password
      }
    },
    methods: {
      login (formName) {
        let self = this
        self.btnLoading = true
        this.$refs[formName].validate((valid) => {
          if (valid) {
            !(async function () {
              let {token} = (await axios.post('/login', qs.stringify({
                username: self.loginFrom.username,
                password: self.loginFrom.password
              })))
              if (token) {
                self.$message.success({
                  message: '登陆成功',
                  duration: 800,
                  onClose: function () {
                    sessionStorage.token = token
                    !(async function () {
                      let {menuses} = await axios.get('/menus')
                      self.$store.commit('getMenu', menuses)
                      let menus = []
                      let url = ''
                      for (let item in self.$store.state.menus) {
                        menus.push(self.$store.state.menus[item])
                      }
                      if (menus[0].url) url = menus[0].url
                      else url = menus[0].children[0].url
                      self.$router.replace(url)
                      self.btnLoading = false
                    }())
                  }
                })
              }
            }())
          } else {
            this.$message.error({
              message: 'Unauthorized'
            })
            self.btnLoading = false
            return false
          }
        })
      }
    },
    directives: {
      focus: {
        inserted (el) {
          el.querySelector('input').focus()
        }
      }
    }
  }
</script>

<style scoped lang="scss">
  .login {
    width: 100vw;
    height: 100vh;
    background: url("/images/login_bg.jpg") no-repeat center;
    position: relative;
    .login-wrap {
      margin-top: 25vh;
      background-color: #fff;
      h2 {
        text-align: center;
        font-weight: normal;
        color: #7d7d7d;
        line-height: 40px;
        font-size: 66px;
        margin: 10px 20px 0 20px;
      }
      h3 {
        font-weight: 100;
        color: #7d7d7d;
        line-height: 35px;
        font-size: 34px;
        margin: 5px 20px 0 20px;
      }
      .el-form {
        margin: 25px 30px 45px 30px;
        .login-btn {
          width: 100%;
        }
      }
    }
  }
</style>
