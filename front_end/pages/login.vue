<template>
  <div class="login">
    <el-row type="flex" justify="center">
      <el-col :span="8" class="login-wrap">
        <h2>Crm</h2>
        <h3>Login</h3>
        <el-form :model="loginFrom" :rules="loginRules" ref="loginFrom">
          <el-form-item prop="username">
            <el-input type="text" v-model="loginFrom.username" auto-complete="off" v-focus="true"
                      placeholder="username"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <el-input type="password" v-model="loginFrom.password" auto-complete="off"
                      @keyup.native.enter="login('loginFrom')" placeholder="password"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button class="login-btn" type="primary" @click="login('loginFrom')" :disabled="disabled">login
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
            {required: true, message: 'username?', trigger: 'blur'},
            {min: 4, max: 15, message: 'length is 4-15', trigger: 'blur'}
          ],
          password: [
            {required: true, message: 'password?', trigger: 'blur'},
            {min: 4, max: 15, message: 'length is 4-15', trigger: 'blur'}
          ]
        }
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
        this.$refs[formName].validate((valid) => {
          if (valid) {
            !(async function () {
              let token = (await axios.post('/login', qs.stringify({
                username: self.loginFrom.username,
                password: self.loginFrom.password
              }))).token
              if (token) {
                self.$message.success({
                  message: 'login success',
                  duration: 800,
                  onClose: function () {
                    sessionStorage.token = token
                    self.$router.replace('/home/console')
                  }
                })
              }
            }())
          } else {
            this.$message.error({
              message: 'Unauthorized'
            })
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
    background: url("/login_bg.jpg") no-repeat center;
    position: relative;
    .login-wrap {
      margin-top: 25vh;
      background-color: #fff;
      h2 {
        font-weight: normal;
        color: #7d7d7d;
        line-height: 40px;
        font-size: 30px;
        margin: 10px 20px 0 20px;
        text-indent: 45px;
        background: url("/logo.png") no-repeat left center;
        background-size: contain;
      }
      h3 {
        font-weight: normal;
        color: #7d7d7d;
        line-height: 35px;
        font-size: 40px;
        margin: 20px 20px 0 20px;
      }
      .el-form {
        margin: 30px;
        .login-btn {
          width: 100%;
        }
      }
    }
  }
</style>
