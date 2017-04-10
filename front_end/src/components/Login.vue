<template>
  <Form ref="formInline" :model="formInline" :rules="ruleInline" inline>
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
      <Button type="primary" @click="handleSubmit('formInline')" :loading="isLoading">登录</Button>
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
            {required: true, message: '请填写用户名', trigger: 'blur'}
          ],
          password: [
            {required: true, message: '请填写密码', trigger: 'blur'},
            {type: 'string', min: 3, message: '密码长度不能小于3位', trigger: 'blur'},
            {type: 'string', max: 10, message: '密码长度不能大于10位', trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      handleSubmit(name) {
        this.isLoading = true
        this.$refs[name].validate((valid) => {
          if (valid) {
            axios.post('http://localhost/crm/back_end/api/v1/token/', qs.stringify({
              username: this.formInline.user.trim(),
              password: this.formInline.password.trim()
            }))
              .then(response => {
                let res = response.data
                if (res['token']) {
                  localStorage.token = res['token']
                  this.$router.push('home')
                } else {
                  if (res.stateCode === 46004) {
                    this.$Message.error('不存在的用户')
                  } else if (res.stateCode === 46005) {
                    this.$Message.error('密码错误')
                  }
                }
                this.isLoading = false
              })
              .catch(err => {
                this.isLoading = false
                this.$Message.error(`网络错误: ${err}`)
              })
          } else {
            this.$Message.error('表单验证失败!')
          }
        })
      }
    }
  }
</script>
<style scoped>
</style>
