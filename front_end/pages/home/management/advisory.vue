<template>
  <div class="advisory-managemnet">
    <h2>咨询方式管理</h2>
    <el-card class="box-card">
      <float-button @click.native="addAdvisory"/>
      <el-table style="width: 100%" border :data="$store.state.advisories ? $store.state.advisories : []">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="咨询方式名称"></el-table-column>
        <el-table-column label="操作">
          <template scope="scope">
            <el-button size="small" icon="edit" @click="editAdvisoryName(scope.$index, scope.row)"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removeDoctor(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import FloatButton from '~components/FloatButton.vue'
  import axios from '../../../config/axios'
  import qs from 'qs'

  export default {
    name: 'advisoryManagement',
    components: {
      FloatButton
    },
    data () {
      return {
        advisories: this.$store.state.advisories ? this.$store.state.advisories : []
      }
    },
    watch: {
      advisories (advisories) {
        this.$store.commit('getAdvisories', advisories)
      }
    },
    methods: {
      addAdvisory () {
        let self = this
        this.$prompt('咨询方式名称', {
          showCancelButton: false,
          confirmButtonText: '创建'
        })
          .then(({value}) => {
            axios.get(`/management/advisories/create/${value}`)
              .then(res => {
                self.advisories.push(res.advisory)
              })
          })
      },
      editAdvisoryName (index, row) {
        let self = this
        this.$prompt('咨询方式名称', {
          showCancelButton: false,
          confirmButtonText: '更改',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/advisories/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.advisories.splice(index, 1, res.advisory)
              })
          })
      },
      removeDoctor (index, row) {
        let self = this
        axios.delete(`/management/advisories/${row.id}`)
          .then(res => {
            self.advisories.splice(index, 1)
          })
      }
    },
    mounted () {
      let self = this
      !(async function () {
        if (!self.$store.state.advisories) {
          let {advisories} = await axios.get('/management/advisories')
          self.advisories = advisories
        }
        self.$store.state.loading = false
      }())
    }
  }
</script>

<style scoped lang="scss"></style>
