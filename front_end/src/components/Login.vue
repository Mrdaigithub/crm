<template>
  <div>
    <form>
      <Poptip trigger="focus" title="username" content="username" placement="right">
        <Input v-model="username" icon="person" placeholder="username"></Input>
      </Poptip>
      <br>
      <Poptip trigger="focus" title="password" content="password" placement="right">
        <Input type="password" v-model="sourcePassword" icon="locked" placeholder="username"></Input>
      </Poptip>
      <br>
      <Button type="success" @click="login">login</Button>
    </form>
  </div>
</template>
<script>
  import md5 from 'js-md5'
  import axios from 'axios'
  export default{
    name: 'login',
    data: function () {
      return {
        username: '',
        sourcePassword: '',
      }
    },
    computed: {
      md5Password: function () {
        if (!this.sourcePassword) return ''
        return this.sourcePassword
      }
    },
    methods: {
      login: function () {
        axios.post('http://127.0.0.1/crm/back_end/api/v1/token/', {
          username: this.username,
          md5Password: this.md5Password
        })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    filters: {
      clearSpace: function (value) {
        return value.replace(/\s/g, '')
      }
    }
  }
</script>
<style scoped>
</style>
