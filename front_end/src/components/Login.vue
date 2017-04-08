<template>
  <div>
    <form>
      <Poptip trigger="focus" title="提示标题" content="提示内容" placement="right">
        <Input v-model="username" icon="person" placeholder="username"></Input>
      </Poptip>
      <br>
      <Poptip trigger="focus" title="提示标题" content="提示内容" placement="right">
        <Input type="password" v-model="sourcePassword" icon="locked" placeholder="username"></Input>
      </Poptip>
      <button type="button" @click="login">submit</button>
    </form>
  </div>
</template>
<script>
  import md5 from 'js-md5'
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
//        axios.post('/user', {
//          firstName: 'Fred',
//          lastName: 'Flintstone'
//        })
//          .then(function (response) {
//            console.log(response);
//          })
//          .catch(function (error) {
//            console.log(error);
//          });
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
  .center-right {
    float: right;
  }
</style>
