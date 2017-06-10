<template>
  <div class="login">
    <el-form :model="loginFrom" :rules="loginRules" ref="loginFrom" label-width="100px">
      <el-form-item label="username" prop="username">
        <el-input type="text" v-model="loginFrom.username" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item label="password" prop="password">
        <el-input type="password" v-model="loginFrom.password" auto-complete="off"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="login('loginFrom')">提交</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
  export default {
    name: 'login',
    data() {
      return {
        loginFrom: {
          username: '',
          password: '',
        },
        loginRules: {
          username: [
            { required: true, message: 'username?', trigger: 'blur' },
            { min: 4, max: 15, message: 'length is 4-15', trigger: 'blur' }
          ],
          password: [
            { required: true, message: 'password?', trigger: 'blur' },
            { min: 4, max: 15, message: 'length is 4-15', trigger: 'blur' }
          ]
        }
      };
    },
    methods: {
      login(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            alert('submit!');
          } else {
            return false;
          }
        });
      }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>
