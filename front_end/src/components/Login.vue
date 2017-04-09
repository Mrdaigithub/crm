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
      <Button type="primary" @click="handleSubmit('formInline')">登录</Button>
    </Form-item>
  </Form>
</template>
<script>
  import axios from 'axios'
  import qs from 'qs'
  export default{
    name: 'login',
    data: function () {
      return {
        formInline: {
          user: '',
          password: ''
        },
        ruleInline: {
          user: [
            { required: true, message: '请填写用户名', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请填写密码', trigger: 'blur' },
            { type: 'string', min: 1, message: '密码长度不能小于6位', trigger: 'blur' }
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
                this.isLoading = false
                if (res['token']){
                  localStorage.token = res['token']
                  this.$router.push('index')
                }else {
//                if (res.statusCode === 46004)
                }
              })
              .catch(err =>{
                this.isLoading = false
                console.log(err)
              })
            this.$Message.success('提交成功!');
          } else {
            this.$Message.error('表单验证失败!');
          }
        })
      }
    }
  }
</script>
<style scoped>
</style>
