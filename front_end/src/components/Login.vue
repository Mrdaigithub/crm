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
    data: function () {
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
        this.isLoading = true
        this.$refs[name].validate((valid) => {
          if (valid) {
              let login = async ()=>{
                let res = await axios.post('http://localhost/crm/back_end/api/v1/token/', qs.stringify({
                  username: this.formInline.user.trim(),
                  password: this.formInline.password.trim()
                }))
                res = res.data
                if(res.token){
                  localStorage.token = res.token
                  this.$router.push('home')
                }

                if (res.stateCode === 40036) this.$Message.error('用戶名或密碼缺失')
                if (res.stateCode === 40035) this.$Message.error('用戶名或密碼不合法')
                if (res.stateCode === 46004) this.$Message.error('用户名错误或无此用户')
                if (res.stateCode === 46005) this.$Message.error('密码错误')

                this.isLoading = false
              }
              login()
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
