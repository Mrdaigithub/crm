<template>
  <div class="login">
    <div id="loginBg"></div>
    <el-row>
      <el-col :span="8" :offset="8">
        <el-form :model="loginFrom" :rules="loginRules" ref="loginFrom" label-width="100px">
          <el-form-item label="username" prop="username">
            <el-input type="text" v-model="loginFrom.username" auto-complete="off"></el-input>
          </el-form-item>
          <el-form-item label="password" prop="password">
            <el-input type="password" v-model="loginFrom.password" auto-complete="off"
                      @keyup.native.enter="login('loginFrom')"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button class="login-btn" type="primary" @click="login('loginFrom')" :disabled="disabled">login</el-button>
          </el-form-item>
        </el-form>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  import JParticles from 'jparticles'
  import axios from '../config/axiosConfig'
  import qs from 'qs'

  export default {
    name: 'login',
    data() {
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
      };
    },
    computed: {
      disabled(){
        return !this.loginFrom.username || !this.loginFrom.password
      }
    },
    methods: {
      login(formName) {
        let self = this;
        this.$refs[formName].validate((valid) => {
          if (valid) {
            !async function () {
              let token = (await axios.post('/token', qs.stringify({
                username: self.loginFrom.username,
                password: self.loginFrom.password
              }))).token;
              if (token) {
                self.$message.success({
                  message: 'login success',
                  duration: 800,
                  onClose: function () {
                    sessionStorage.token = token;
                    self.$router.replace('/home/console');
                  }
                });
              }
            }()
          } else {
            this.$message.error({
              message: 'Unauthorized',
            });
            return false;
          }
        });
      }
    },
    mounted(){
//      new JParticles.particle('#loginBg', {
//        proximity: 90,
//        maxR: 5,
//        minR: 1,
//        range: 1000
//      });
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .login {
    position: relative;
    #loginBg {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100vh;
    }
    .el-form {
      margin-top: 25vh;
      .login-btn {
        width: 100%;
      }
    }
  }
</style>
