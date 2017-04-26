<template>
  <div>
    <h1>permission</h1>
    <Tree :data="baseData" show-checkbox></Tree>
  </div>
</template>
<script>
  import qs from 'qs'
  import axios from 'axios'
  export default {
    name: 'permission',
    data () {
      return {
        baseData: [
          {
            expand: true,
            title: 'parent 1',
            children: [
              {
                title: 'parent 1-0',
                expand: true,
                disabled: true,
                children: [
                  {
                    title: 'leaf',
                    disableCheckbox: true,
                    children:[]
                  },
                  {
                    title: 'leaf',
                  }
                ]
              },
              {
                title: 'parent 1-1',
                expand: true,
                checked: true,
                children: [
                  {
                    title: '<span style="color: red">leaf</span>',
                    children:[
                    ]
                  }
                ]
              }
            ]
          }
        ]
      }
    }
  }
</script>
<style>
</style>
