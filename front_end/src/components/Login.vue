<template>
  <Form ref="formInline" :model="formInline" :rules="ruleInline" class="login-form">
    <Form-item prop="user">
      <Input type="text" v-model="formInline.user" placeholder="Username">
      <Icon type="ios-person-outline" slot="prepend"></Icon>
      </Input>
    </Form-item>
    <Form-item prop="password">
      <Input type="password" v-model="formInline.password" placeholder="Password">
      <Icon type="ios-locked-outline" slot="prepend"></Icon>
      </Input>
    </Form-item>
    <Form-item>
      <Button type="primary" @click="handleSubmit('formInline')" :loading="isLoading" long>登录</Button>
    </Form-item>
  </Form>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'

  export default{
    name: 'login',
    data(){
      return {
        isLoading: false,
        formInline: {
          user: '',
          password: ''
        },
        ruleInline: {
          user: [
            {required: true, message: '请填写用户名', trigger: 'blur'},
            {pattern: /^[0-9a-zA-Z]+$/, message: '不能包含特殊字符', trigger: 'blur'},
            {type: 'string', min: 4, message: '账户长度不能小于4位', trigger: 'blur'},
            {type: 'string', max: 10, message: '账户长度不能大于10位', trigger: 'blur'}
          ],
          password: [
            {required: true, message: '请填写密码', trigger: 'blur'},
            {pattern: /^[0-9a-zA-Z]+$/, message: '不能包含特殊字符', trigger: 'blur'},
            {type: 'string', min: 3, message: '密码长度不能小于3位', trigger: 'blur'},
            {type: 'string', max: 15, message: '密码长度不能大于15位', trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSubmit(name) {
        let self = this
        this.isLoading = true
        this.$refs[name].validate((valid) => {
          if (valid) {
            !async function () {
              let res = (await axios.post('http://crm.mrdaisite.com/back_end/api/v1/token/', qs.stringify({
                username: self.formInline.user.trim(),
                password: self.formInline.password.trim()
              }))).data
              if (res.token) {
                localStorage.token = res.token
                self.$router.push('home')
              }

              if (res['state_code'] === 40036) self.$Message.error('用戶名或密碼缺失')
              if (res['state_code'] === 40035) self.$Message.error('用戶名或密碼不合法')
              if (res['state_code'] === 46004) self.$Message.error('用户名错误或无此用户')
              if (res['state_code'] === 46005) self.$Message.error('密码错误')

              self.isLoading = false
            }()
          } else {
            this.$Message.error('native!')
            this.isLoading = false
          }
        })
      }
    }
  }
</script>
<style scoped>
  .login-form {
    text-align: center;
    width: 20vw;
    margin: 30vh auto 0 auto;
  }
</style>
