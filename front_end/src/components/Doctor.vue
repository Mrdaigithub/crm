<template>
  <div>
    <h1>doctor template</h1>
    <Table :columns="doctorCol" :data="doctorData"></Table>
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default{
    data(){
      return {
        doctorCol: [
          {
            title: '编号',
            key: 'id'
          }, {
            title: '姓名',
            key: 'name'
          }, {
            title: '状态',
            key: 'state'
          }
        ],
        doctorData: []
      }
    }
  }
</script>
